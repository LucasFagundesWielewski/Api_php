<?php

namespace App\Models;

use mysqli;

class User extends Database {
    public static function save(array $data) {
        $conn = self::getConnection();

        $stmt = $conn->prepare("
            INSERT INTO users (name, email, password)
            VALUES (?, ?, ?)
        ");
        $stmt->bind_param("sss", $data['name'], $data['email'], $data['password']);
        $stmt->execute();

        return $stmt->affected_rows > 0;
    }

    public static function findByEmail($email) {
        $conn = self::getConnection();

        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();

        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public static function isPasswordUsed($password) {
        $conn = self::getConnection();

        $stmt = $conn->prepare("SELECT password FROM users");
        $stmt->execute();

        $result = $stmt->get_result();
        while ($user = $result->fetch_assoc()) {
            if (password_verify($password, $user['password'])) {
                return true;
            }
        }

        return false;
    }
}
