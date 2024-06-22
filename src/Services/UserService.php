<?php

namespace App\Services;

use App\Utils\Validator;
use Exception;
use PDOExeption;
use App\Models\User;

class UserService {
    public static function create(array $data) {
        try {
            $fields = Validator::validate([
                'name'      =>$data['name']     ?? '',
                'email'     =>$data['email']    ?? '',
                'password'  =>$data['password'] ?? ''
            ]);
            $user = User::save($fields);

            if (!$user) return ['error' => 'Sorry, we could not create yor account.'];

            return "User created successfully!";
        }
        catch (PDOExeption $e) {
            return ['error' => $e->getMessage()];
        }
        catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}