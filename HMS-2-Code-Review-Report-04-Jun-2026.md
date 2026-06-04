# HMS-2 Code Review Report

## 1. Executive Summary

**Overall Codebase Quality**
The HMS-2 (Businzo RCMS) codebase is in a transitional state. It shows clear intentions of moving toward modern standards (introducing a Slim framework-based API, Dockerization, PDO, and white-labeling features) but is heavily weighed down by a legacy, procedural PHP monolith. Security vulnerabilities in the legacy code are the most pressing concern.

**Top Strengths**
- **Modern API Introduction:** The `api/` directory utilizes the Slim framework, dependency injection, routing, and middleware, showing a solid modern architectural pattern.
- **Multi-Tenant White-Labeling:** The dynamic subdomain and organization resolution (`Includes/config.php`) is a well-implemented feature for SaaS scalability.
- **Containerization:** Providing a `docker-compose.yml` and `Dockerfile` ensures consistent deployment environments.

**Critical Concerns**
- **Severe Security Vulnerabilities:** Legacy modules (e.g., `admin/Members/admin_class.php`) use `extract($_POST)` and direct string concatenation in SQL queries, resulting in massive SQL Injection (SQLi) risks.
- **Inconsistent Password Hashing:** The web login uses `password_verify` with bcrypt, but the modern `AuthController.php` falls back to `md5()`, creating broken authentication states and security flaws.
- **Dual Architecture & Redundancy:** The codebase initializes both `mysqli` and `PDO` connections simultaneously, and the directory structure is heavily duplicated across user roles (admin, staff, resident, etc.).

---

## 2. Architecture & Project Structure

**Folder Organization and Layering**
- The project structure is heavily fragmented. Legacy folders (`admin/`, `members/`, `staff/`, `resident/`, `super_admin/`) suggest a pattern of duplicating files per user role rather than utilizing a unified MVC pattern with Role-Based Access Control (RBAC).
- The `api/` folder introduces a clean, separate PSR-4 compliant structure (Controllers, Middleware, Routes) but creates a stark divide in how the application operates.

**Design Patterns Used (or Missing)**
- **Singleton Pattern:** Used in `Database.php` to maintain DB connection state (Good).
- **Missing MVC (in legacy):** Presentation logic (HTML) and data access (SQL) are tightly coupled in files like `admin/Dashboard/admin.php`.
- **Middleware:** Effectively used in the API for CORS and Security.

**Scalability and Extensibility Assessment**
The codebase is currently difficult to scale. Maintaining parallel connection paradigms (`mysqli` and `PDO`) and role-based folder structures means a single feature update requires changes in multiple places. Transitioning fully to the `api/` architecture is essential for long-term scalability.

---

## 3. File-by-File / Class-by-Class Review

### File: `admin/Members/admin_class.php`
- **Purpose:** Handles CRUD operations for members in the admin portal.
- **What’s Good:** Basic OOP wrapper around actions.
- **Issues Identified:** Highly insecure. Uses `extract($_POST)` which allows variable injection. Concatenates POST data directly into SQL strings without sanitization.
- **Recommendations:** Remove `extract()`. Refactor to use PDO prepared statements exclusively.

### File: `api/src/Controllers/AuthController.php`
- **Purpose:** Handles API authentication and JWT issuance.
- **What’s Good:** Good use of `Rakit\Validation` for input validation. Implements Access and Refresh tokens with a denylist.
- **Issues Identified:** 
  1. Uses `md5($parsedBody['password'])` which is easily crackable and inconsistent with `register.php` (which uses `password_hash`). 
  2. Hardcoded JWT secret key (`private $secretKey = 'YOUR_SUPER_SECRET_KEY';`).
- **Recommendations:** Replace `md5()` with `password_verify()`. Move the secret key to the `.env` file.

### File: `Includes/Database.php`
- **Purpose:** Singleton database connection provider.
- **What’s Good:** Loads `.env` variables cleanly.
- **Issues Identified:** Initializes both `mysqli` and `PDO` connections for every request, wasting memory and database connection limits.
- **Recommendations:** Deprecate `mysqli` entirely across the project and return only the `PDO` instance.

### File: `admin/Dashboard/admin.php`
- **Purpose:** Admin dashboard statistics overview.
- **What’s Good:** Clean HTML structure and CSS class usage.
- **Issues Identified:** Mixes raw SQL queries with HTML rendering. Uses outdated `mysqli_query` instead of PDO.
- **Recommendations:** Move data fetching logic to a Controller or Service class and pass the variables to a clean View template.

---

## 4. Cross-Cutting Issues

- **Code Duplication:** Having separate dashboards for `admin`, `staff`, `resident`, etc., often leads to duplicated HTML headers, sidebars, and common CRUD logic.
- **Inconsistent Patterns:** The API uses `App\Controllers` (OOP), while the legacy backend uses procedural PHP (`mysqli_query`, `extract`).
- **Config Management Issues:** JWT secrets are hardcoded in Controllers instead of centralized in the `.env` configuration.
- **Password Hashing:** Web registration uses robust `password_hash()` (bcrypt), while API login checks for `md5()`. Users registered on the web cannot log in via the API.

---

## 5. Error Handling Review

- **Current Approach:** Legacy PHP code relies on `ini_set('display_errors', 1)` or fails silently. The API uses Slim's built-in Error Middleware and returns standard JSON responses.
- **Risk Areas:** Database connection failures in legacy code use `die()`, resulting in poor user experience and potential exposure of sensitive path data.
- **Recommendations for Standardization:** Implement a global exception handler. Stop using `die()` in production code. Ensure all database interactions are wrapped in `try-catch` blocks.

---

## 6. Detailed Improvement Actions

### Issue 1: SQL Injection in Legacy Classes
- **Problem:** User input is directly inserted into database queries.
- **Location:** `admin/Members/admin_class.php` (Function: `save_user`)
- **Impact:** Critical. An attacker could drop tables, modify data, or bypass authentication.
- **Recommendation:** Use PDO prepared statements.

**Improved Code Snippet:**
```php
// Refactored save_user function
function save_user() {
    $pdo = $this->db->getPDO(); // Use PDO instead of mysqli
    
    // Validate inputs (example)
    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $id = $_POST['id'] ?? null;
    
    // Check existing
    $stmt = $pdo->prepare("SELECT id FROM member WHERE username = :username AND id != :id");
    $stmt->execute(['username' => $username, 'id' => $id ?? 0]);
    if ($stmt->fetch()) return 2;
    
    if (empty($id)) {
        $stmt = $pdo->prepare("INSERT INTO member (email, username) VALUES (:email, :username)");
        $stmt->execute(['email' => $email, 'username' => $username]);
    } else {
        $stmt = $pdo->prepare("UPDATE member SET email = :email, username = :username WHERE id = :id");
        $stmt->execute(['email' => $email, 'username' => $username, 'id' => $id]);
    }
    return 1;
}
```

### Issue 2: Hardcoded Secrets & Weak Hashing in API
- **Problem:** JWT tokens are signed with a hardcoded string, and passwords use MD5.
- **Location:** `api/src/Controllers/AuthController.php`
- **Impact:** Critical. Anyone with source code access can forge API tokens. MD5 passwords can be easily cracked via rainbow tables.
- **Recommendation:** Load secret from `getenv('JWT_SECRET')` and use `password_verify()`.

**Improved Code Snippet:**
```php
// Inside AuthController::login
$this->secretKey = getenv('JWT_SECRET') ?: throw new \Exception('JWT Secret not configured');

$username = $parsedBody['username'];
$password = $parsedBody['password']; 

$pdo = Database::getInstance()->getPDO();
$stmt = $pdo->prepare("SELECT * FROM `$table` WHERE username = ?");
$stmt->execute([$username]);
$user = $stmt->fetch(\PDO::FETCH_ASSOC);

if (!$user || !password_verify($password, $user['password'])) {
    return ResponseFormatter::error($response, 'Invalid credentials', null, 401);
}
```

---

## 7. Security & Performance Review

**Security Risks and Vulnerabilities**
- `extract($_POST)` allows variable overriding. If a developer uses a variable like `$is_admin = false` before `extract()`, a user passing `is_admin=1` in the POST payload can override it.
- Missing CSRF protection on legacy POST forms.

**Performance Issues and Optimization Opportunities**
- Double Database Connections (`Database.php` connects to both `mysqli` and `PDO`). Dropping `mysqli` halves the DB connection overhead per request.
- `SELECT *` is heavily used (e.g., `SELECT * FROM member`). Select only the columns needed (e.g., `SELECT id, username FROM member`) to reduce memory consumption.

---

## 8. Final Implementation Guide

**1. Critical fixes (must-do immediately)**
- Refactor `api/src/Controllers/AuthController.php` to use `.env` for the JWT secret.
- Update `AuthController.php` to use `password_verify()` to resolve the authentication mismatch with the web app.
- Audit and patch all legacy classes (like `admin_class.php`) removing `extract($_POST)` and replacing `mysqli_query` string concatenations with PDO prepared statements.

**2. High-impact improvements**
- Remove `$this->mysqli` from `Includes/Database.php`. Search the codebase for `mysqli_` functions and `$con->query` and replace them with their PDO equivalents.
- Centralize routing. Consider moving all traffic through the `index.php` or the Slim framework, slowly migrating legacy views into the modern structure.

**3. Nice-to-have optimizations**
- Implement a template engine (like Twig or Blade) to separate HTML from PHP logic entirely.
- Consolidate the role-based folder structures into a single `Views` directory governed by an RBAC (Role-Based Access Control) middleware.

---

## 9. Code Quality Rating

**Score: 4 / 10**

**Justification:**
1. **Security Gaps:** Widespread SQL injection vulnerabilities in legacy files and weak cryptography in the API severely drag the score down.
2. **Technical Debt:** Running `mysqli` and `PDO` simultaneously, alongside two completely different architectural patterns (procedural monolith vs. API framework), makes maintenance highly error-prone.
3. **Redeeming Qualities:** The groundwork for a modern application is present. The use of `.env`, Docker, Slim API, and JWT tokens shows a clear path forward once the legacy debt is addressed.
