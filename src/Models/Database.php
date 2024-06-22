<?php

namespace App\Models;

class Database {
    private static $servername = "localhost";
    private static $username = "root";
    private static $password = "";
    private static $db_name = "apia";
    private static $conn;

    protected static function getConnection() {
        if (!isset(self::$conn)) {
            self::$conn = new \mysqli(self::$servername, self::$username, self::$password, self::$db_name);

            if (self::$conn->connect_error) {
                die("Connection failed: " . self::$conn->connect_error);
            }
        }
        return self::$conn;
    }
}
