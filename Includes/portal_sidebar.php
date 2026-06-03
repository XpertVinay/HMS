<?php
if (basename(__FILE__) == basename($_SERVER["SCRIPT_FILENAME"])) { die('Direct access not permitted.'); }
$current_page = basename($_SERVER['PHP_SELF']);
$dir_path = dirname($_SERVER['PHP_SELF']);

function isActive($page) {
    global $current_page, $dir_path;
    return (strpos($dir_path, $page) !== false || $current_page == $page) ? 'active' : '';
}
?>
<div class="sidebar">
    <div class="logo-details">
        <a href="/home/home.php">
            <i><img src="/1.png" alt="logo"></i>
        </a>
        <span class="logo_name">HMS</span>
    </div>
    <ul class="nav-links">
        <?php if ($role == 'admin'): ?>
            <li><a href="/admin/Dashboard/admin.php" class="<?php echo isActive('Dashboard'); ?>"><i class='bx bx-grid-alt'></i><span class="links_name">Dashboard</span></a></li>
            <li><a href="/admin/Announcement/admin_annou.php" class="<?php echo isActive('Announcement'); ?>"><i class='bx bx-bell'></i><span class="links_name">Notices</span></a></li>
            <li><a href="/admin/Bill/index.php" class="<?php echo isActive('Bill'); ?>"><i class='bx bx-pie-chart-alt-2'></i><span class="links_name">Bills</span></a></li>
            <li><a href="/admin/Home_Services/home_ser.php" class="<?php echo isActive('Home_Services'); ?>"><i class='bx bxs-user-circle'></i><span class="links_name">Services</span></a></li>
            <li><a href="/admin/Neighbourhood/admin_neigh.php" class="<?php echo isActive('Neighbourhood'); ?>"><i class='bx bx-map'></i><span class="links_name">Neighbours</span></a></li>
            <li><a href="/admin/Members/index.php" class="<?php echo isActive('Members'); ?>"><i class='bx bx-list-ul'></i><span class="links_name">Members</span></a></li>
            <li><a href="/admin/Members/staff/index.php" class="<?php echo isActive('staff'); ?>"><i class='bx bx-list-ul'></i><span class="links_name">Staff</span></a></li>
            <li><a href="/admin/Donors/index.php" class="<?php echo isActive('Donors'); ?>"><i class='bx bx-donate-heart'></i><span class="links_name">Donors</span></a></li>
            <li><a href="/admin/Sponsors/index.php" class="<?php echo isActive('Sponsors'); ?>"><i class='bx bx-star'></i><span class="links_name">Sponsors</span></a></li>
            <li><a href="/admin/Event_calender/admin_event.php" class="<?php echo isActive('Event_calender'); ?>"><i class='bx bx-calendar-event'></i><span class="links_name">Events</span></a></li>
            <li><a href="/admin/Gallery/index.php" class="<?php echo isActive('Gallery'); ?>"><i class='bx bx-image'></i><span class="links_name">Gallery</span></a></li>

        <?php elseif ($role == 'member'): ?>
            <li><a href="/members/Dashboard/member.php" class="<?php echo isActive('Dashboard'); ?>"><i class='bx bx-grid-alt'></i><span class="links_name">Dashboard</span></a></li>
            <li><a href="/members/Announcement/member_annou.php" class="<?php echo isActive('Announcement'); ?>"><i class='bx bx-bell'></i><span class="links_name">Notices</span></a></li>
            <li><a href="/members/Bill/index.php" class="<?php echo isActive('Bill'); ?>"><i class='bx bx-pie-chart-alt-2'></i><span class="links_name">Bills</span></a></li>
            <li><a href="/members/Home_Services/home_ser.php" class="<?php echo isActive('Home_Services'); ?>"><i class='bx bxs-user-circle'></i><span class="links_name">Services</span></a></li>
            <li><a href="/members/Neighbourhood/member_neigh.php" class="<?php echo isActive('Neighbourhood'); ?>"><i class='bx bx-map'></i><span class="links_name">Neighbours</span></a></li>
            <li><a href="/members/Members/index.php" class="<?php echo isActive('Members'); ?>"><i class='bx bx-list-ul'></i><span class="links_name">Members</span></a></li>
            <li><a href="/members/Members/staff/index.php" class="<?php echo isActive('staff'); ?>"><i class='bx bx-list-ul'></i><span class="links_name">Staff</span></a></li>
            <li><a href="/members/Event_calender/member_event.php" class="<?php echo isActive('Event_calender'); ?>"><i class='bx bx-calendar-event'></i><span class="links_name">Events</span></a></li>

        <?php elseif ($role == 'staff'): ?>
            <li><a href="/staff/Dashboard/staff.php" class="<?php echo isActive('Dashboard'); ?>"><i class='bx bx-grid-alt'></i><span class="links_name">Dashboard</span></a></li>
            <li><a href="/staff/Announcement/staff_annou.php" class="<?php echo isActive('Announcement'); ?>"><i class='bx bx-bell'></i><span class="links_name">Notices</span></a></li>
            <li><a href="/staff/Neighbourhood/staff_neigh.php" class="<?php echo isActive('Neighbourhood'); ?>"><i class='bx bx-map'></i><span class="links_name">Neighbours</span></a></li>
            <li><a href="/staff/Members/index.php" class="<?php echo isActive('Members'); ?>"><i class='bx bx-list-ul'></i><span class="links_name">Members</span></a></li>
            <li><a href="/staff/Event_calender/staff_event.php" class="<?php echo isActive('Event_calender'); ?>"><i class='bx bx-calendar-event'></i><span class="links_name">Events</span></a></li>
        <?php endif; ?>
        

        <li class="log_out"><a href="/logout.php"><i class='bx bx-log-out'></i><span class="links_name">Log out</span></a></li>
    </ul>
</div>

<section class="home-section">
    <nav>
        <div class="sidebar-button">
            <i class='bx bx-menu sidebarBtn'></i>
            <span class="dashboard"><?php echo ucfirst($role); ?> Portal</span>
        </div>
        <div class="profile-details" style="display:flex; align-items:center; gap:10px;">
            <div style="width: 32px; height: 32px; border-radius: 50%; background: var(--primary-color); color: white; display: flex; align-items: center; justify-content: center; font-weight: bold;">
                <?php echo strtoupper(substr($username, 0, 1)); ?>
            </div>
            <span class="admin_name" style="font-weight:600;"><?php echo htmlspecialchars($username); ?></span>
        </div>
    </nav>
    <div class="home-content">
