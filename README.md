
# Tour & Travel Website

This is a simple tour and travel website built with PHP and MySQL.

## Installation

1. Clone the repository:
```bash
git clone <repository-url>
```

2. Import the database:
- Create a new database named `webdulich` in your MySQL server.
- Import the `db.sql` file into the `webdulich` database.

3. Configure the database connection:
- Open the `includes/config.php` and `admin/includes/config.php` files.
- Update the database credentials (host, username, password, and database name) to match your local environment.

## Running the application

1. Start your local web server (e.g., XAMPP, WAMP).
2. Open the project in your web browser.

## Database Design

The database consists of the following tables:

- `tblusers`: Stores user information.
- `tbltourpackages`: Stores tour package details.
- `tblbooking`: Stores booking information.
- `tblissues`: Stores user-reported issues.
- `tblpages`: Stores static page content.
- `tblenquiry`: Stores user enquiries.
- `tbladmin`: Stores admin user information.
- `tblpasswordreset`: Stores password reset tokens.
