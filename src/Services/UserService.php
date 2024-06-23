<?php

namespace App\Services;

use App\Utils\Validator;
use Exception;
use PDOException;
use App\Models\User;

class UserService {
    public static function create(array $data) {
        try {
            $fields = Validator::validate([
                'name'      => $data['name']     ?? '',
                'email'     => $data['email']    ?? '',
                'password'  => $data['password'] ?? ''
            ]);

            if (User::findByEmail($fields['email'])) {
                return ['error' => 'Email already in use.'];
            }

            if (User::isPasswordUsed($fields['password'])) {
                return ['error' => 'Password already in use.'];
            }

            $fields['password'] = password_hash($fields['password'], PASSWORD_DEFAULT);

            $user = User::save($fields);

            if (!$user) return ['error' => 'Sorry, we could not create your account.'];

            return "User created successfully!";
        }
        catch (PDOException $e) {
            return ['error' => $e->errorInfo[0]];
        }
        catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}
