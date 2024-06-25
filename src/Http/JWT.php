<?php

namespace App\Http;

class JWT {
    private static string $secret = "secret-key";

    public static function generate(array $data = []) {

        $header = json_encode(['typ' => 'JWT', 'alg' => 'HS256']);
        $payload = json_encode($data);

        $base64UrlHeader = self::base64url_encode($header);
        $base64UrlPayload = self::base64url_encode($payload);

        $signature = self::signature($base64UrlHeader, $base64UrlPayload);

        $jwt = $base64UrlHeader . "." . $base64UrlPayload . "." . $signature;

        return $jwt;
    }
}