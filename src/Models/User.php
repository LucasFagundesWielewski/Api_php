<?php

namespace App\Models;

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
}
