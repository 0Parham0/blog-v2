# Blog 

A weblog that allows everyone to sign up and write their own blogs to be shown to everyone.

## Requirements

- PHP 8.3 or later
- Apache server
- MariaDB 10.4 or MySQL 5.7 or later

## Installation

### 1. Clone the Repository

### 2. Database Configuration

Open `config.php` and update the database connection details:

- `host`: MySQL server address (usually "localhost")
- `username`: Your MySQL username
- `password`: Your MySQL password
- `dbname`: ِDO NOT CHANGE

### 3. Database Setup

1. Ensure that `createDbAndTables.sql` is in the same directory as `setupDatabase.php`.
2. Run the database setup script:

- Via browser: Navigate to `http://localhost/[project-name]/database/setupDatabase`

3. You should see a confirmation message upon successful setup.

### 4. Web Server Configuration

Configure your Apache server to point to the project's public directory.

### 5. Apache Configuration

Ensure that your Apache server has mod_rewrite enabled and AllowOverride is set to All in your Apache configuration.

The project uses an .htaccess file for URL rewriting. Make sure the file is present in the root directory.

## Security Notes

- After successful setup, delete `database/setupDatabase.php` and `database/createDbAndTables.sql` for security reasons.

## Usage

1. Start your web server (Apache) and ensure MySQL is running.
2. Open your web browser and navigate to:
   `http://localhost/[project-name]`
3. You should see the homepage of the weblog application.
