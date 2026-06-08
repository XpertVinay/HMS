#!/bin/bash
set -euo pipefail

# Run on a fresh Ubuntu/Debian VPS as root or with sudo.
# Review each section before running in production.

if [[ "${EUID:-$(id -u)}" -ne 0 ]]; then
    echo "Run as root: sudo bash scripts/vps-hardening.sh"
    exit 1
fi

echo "=== VPS Security Hardening ==="

# --- 1. System updates ---
export DEBIAN_FRONTEND=noninteractive
apt-get update -y
apt-get upgrade -y
apt-get install -y ufw fail2ban unattended-upgrades apt-listchanges

# --- 2. Create deploy user (skip if exists) ---
DEPLOY_USER="${DEPLOY_USER:-deploy}"
if ! id "$DEPLOY_USER" &>/dev/null; then
    adduser --disabled-password --gecos "" "$DEPLOY_USER"
    usermod -aG docker "$DEPLOY_USER" 2>/dev/null || true
    mkdir -p "/home/$DEPLOY_USER/.ssh"
    chmod 700 "/home/$DEPLOY_USER/.ssh"
    echo "Created user: $DEPLOY_USER — add your SSH public key to /home/$DEPLOY_USER/.ssh/authorized_keys"
fi

# --- 3. SSH hardening ---
SSHD_CONFIG="/etc/ssh/sshd_config"
cp "$SSHD_CONFIG" "${SSHD_CONFIG}.bak.$(date +%Y%m%d)"

sed -i 's/^#\?PermitRootLogin.*/PermitRootLogin no/' "$SSHD_CONFIG"
sed -i 's/^#\?PasswordAuthentication.*/PasswordAuthentication no/' "$SSHD_CONFIG"
sed -i 's/^#\?PubkeyAuthentication.*/PubkeyAuthentication yes/' "$SSHD_CONFIG"
sed -i 's/^#\?X11Forwarding.*/X11Forwarding no/' "$SSHD_CONFIG"
sed -i 's/^#\?MaxAuthTries.*/MaxAuthTries 3/' "$SSHD_CONFIG"
grep -q '^ClientAliveInterval' "$SSHD_CONFIG" || echo 'ClientAliveInterval 300' >> "$SSHD_CONFIG"
grep -q '^ClientAliveCountMax' "$SSHD_CONFIG" || echo 'ClientAliveCountMax 2' >> "$SSHD_CONFIG"

systemctl reload sshd || systemctl reload ssh

# --- 4. Firewall ---
ufw default deny incoming
ufw default allow outgoing
ufw allow OpenSSH
ufw allow 80/tcp
ufw allow 443/tcp
ufw --force enable

# --- 5. Fail2ban ---
cat > /etc/fail2ban/jail.local <<'EOF'
[DEFAULT]
bantime  = 1h
findtime = 10m
maxretry = 5

[sshd]
enabled = true
port    = ssh
logpath = %(sshd_log)s
backend = %(sshd_backend)s

[nginx-http-auth]
enabled = true
port    = http,https
logpath = /var/log/nginx/error.log

[nginx-limit-req]
enabled = true
port    = http,https
logpath = /var/log/nginx/error.log
maxretry = 10
EOF

systemctl enable fail2ban
systemctl restart fail2ban

# --- 6. Automatic security updates ---
cat > /etc/apt/apt.conf.d/20auto-upgrades <<'EOF'
APT::Periodic::Update-Package-Lists "1";
APT::Periodic::Unattended-Upgrade "1";
APT::Periodic::AutocleanInterval "7";
EOF

systemctl enable unattended-upgrades
systemctl start unattended-upgrades

# --- 7. Kernel / network hardening ---
SYSCTL_CONF="/etc/sysctl.d/99-hms-security.conf"
cat > "$SYSCTL_CONF" <<'EOF'
net.ipv4.conf.all.rp_filter = 1
net.ipv4.conf.default.rp_filter = 1
net.ipv4.icmp_echo_ignore_broadcasts = 1
net.ipv4.conf.all.accept_redirects = 0
net.ipv4.conf.default.accept_redirects = 0
net.ipv4.conf.all.send_redirects = 0
net.ipv4.conf.default.send_redirects = 0
net.ipv4.tcp_syncookies = 1
EOF
sysctl --system

echo ""
echo "=== Hardening complete ==="
echo "Next steps:"
echo "  1. Add SSH key for '$DEPLOY_USER' before logging out"
echo "  2. Set APP_ENV=production, APP_DEBUG=false in .env"
echo "  3. Use strong DB_PASSWORD and REDIS_PASSWORD"
echo "  4. Install SSL: certbot certonly --nginx -d yourdomain.com"
echo "  5. Deploy: docker compose -f docker-compose.yml -f docker-compose.prod.yml up -d --build"
