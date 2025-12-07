# 👤 Agent System - User Roles & Database (Back-End Design)

This repository contains the back-end implementation for a basic user management system defining key roles for an Agent system, built using **PHP**, **MySQLi**, and standard MySQL database connections. It supports the Create and Read (CR) functions of CRUD.

---

## Project Requirements Fulfilled:
* **Defined User Roles:** Admin, Player, Agent, Club Manager (validated during creation).
* **Database:** Created using MySQL/MariaDB (Implemented via MySQLi).
* **Backend Code:** PHP code implemented for user creation (`add_user.php`) and user viewing (`index.php`).
    * **NOTE:** Passwords are **NOT** stored securely using `password_hash()` in the current version. See the Security Warning below.

---

## 🚀 Setup and Installation

### Prerequisites
* [XAMPP](https://www.apachefriends.org/index.html) (or equivalent PHP/MySQL environment)
* A web browser

### Steps
1.  **Clone Repository:** Clone this repository into your XAMPP htdocs directory.
    ```bash
    git clone [YOUR_REPOSITORY_LINK] /xampp/htdocs/agent_system
    ```
2.  **Start XAMPP:** Start *Apache* and *MySQL* services in the XAMPP Control Panel.
3.  **Create Database:**
    * Go to `http://localhost/phpmyadmin`.
    * Create a new database named `agent_system`.
4.  **Create Table and Insert Sample Data:**
    * Select the `agent_system` database.
    * Go to the *SQL* tab and run the following command to create the `users` table:
    ```sql
    CREATE TABLE users (
        id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
        username VARCHAR(50) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        role VARCHAR(50) NOT NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    );
    -- Insert sample data manually or via subsequent SQL commands if provided.
    ```
5.  **Access System:** Open the application in your browser: `http://localhost/user_management_system/index.php`.

--- 

## ⚙ File Structure

| File | Description |
| :--- | :--- |
| `index.php` | Main dashboard page for fetching and displaying the user list (R - Read). |
| `db_connect.php` | Database connection setup (Defines `DB_NAME`: `agent_system`). |
| `add_user.php` | Form and logic for adding new users (C - Create), including validation checks. |
| `README.md` | This file. |

---

## ⚠️ Security Warning (CRITICAL)

The `add_user.php` script currently stores passwords in **plain text**. This is highly insecure and must be corrected before deployment.

To securely store passwords, you must modify the following section in `add_user.php`:

```php
// In add_user.php, within the insert logic:

// OLD (INSECURE):
// $param_password = $password; 

// NEW (SECURE):
$param_password = password_hash($password, PASSWORD_DEFAULT);