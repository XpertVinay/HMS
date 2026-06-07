# Businzo Residential Community Management System

**Businzo Residential Community Management System** is a comprehensive solution dedicated to fulfilling community needs and resolutions via an intuitive web and mobile application interface.

Built to streamline the daily operations of residential societies, apartment complexes, and housing communities, Businzo offers a secure, modern, and highly interactive platform for residents, administrators, and staff.

## 🌟 Key Features

### 🏢 Multi-Role Portals
Dedicated, personalized dashboards for different user types:
- **Admin Portal**: Full control over society operations, announcements, billing, and member management.
- **Member Portal**: Access to events, notices, neighbour directories, and service requests.
- **Staff Portal**: Tools for managing daily tasks, visitor logs, and interacting with residents.

### 💬 Real-Time Communication
- **Built-in Floating Chat System**: A WhatsApp-like, real-time messaging widget integrated seamlessly into the portal.
- **Role-Based Access**: Contacts are automatically filtered. Members can chat with Staff and Admins; Admins can broadcast and chat with everyone.
- **Service Providers**: Direct communication channels with hardcoded essential service providers (e.g., Security, Plumbers).

### 🎨 Modern & Dynamic UI
- **Glassmorphism Design**: A premium, state-of-the-art interface featuring frosted glass effects, soft shadows, and clean typography.
- **Dynamic Login Themes**: The login page remembers the last user role and automatically morphs its animated gradient background to match (e.g., Midnight Blue for Admins, Emerald Green for Staff).

### 🔒 Enterprise-Grade Security
- **OWASP Compliant**: Strict direct-access prevention (`basename` checks) on all internal files.
- **Secure Authentication**: Seamless integration of `password_hash` and `password_verify` with fallback migration for legacy accounts.
- **SQLi Protection**: Full adoption of PDO Prepared Statements across all database interactions.
- **Clean Routing**: Custom `.htaccess` URL rewriting to hide `.php` extensions while preserving strict `POST` payload integrity.

## 🚀 Getting Started

This application is containerized for easy deployment and testing.

### Prerequisites
- [Docker](https://www.docker.com/) and Docker Compose installed on your machine.

### Installation & Execution
1. Clone the repository and navigate to the project root (`HMS-2`).
2. Run the following command to build and start the application:
   ```bash
   docker compose up --build -d
   ```
3. The web application will be accessible at: `http://localhost:8080/`

## 🤝 Purpose
The Businzo Residential Community Management System acts as the central hub for housing societies, bridging the communication gap between management committees, residents, and service staff, ensuring a harmonious and efficiently run community.