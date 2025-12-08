<?php
class Database {
    private static $instance = null;
    private $dbh;

    private function __construct() {
        // DB credentials.
        define('DB_HOST', getenv('DB_HOST') ?: 'localhost');
        define('DB_USER', getenv('DB_USER') ?: 'root');
        define('DB_PASS', getenv('DB_PASS') ?: '');
        define('DB_NAME', getenv('DB_NAME') ?: 'webdulich');

        // Establish database connection.
        try
        {
            $this->dbh = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=utf8mb4",DB_USER, DB_PASS,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8mb4'"));
        }
        catch (PDOException $e)
        {
            exit("Error: " . $e->getMessage());
        }
    }

    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->dbh;
    }
}
