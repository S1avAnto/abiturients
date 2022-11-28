<?php
declare(strict_types=1);

namespace App;

use app\Exceptions\JWTInvalidStructure;

class JWT
{
    // Симетричное шифрование
    // При использовании симметричного алгоритма один и тот же ключ знают как сервер,
    // выдающий токен, так и сервер, проверяющий его.
    // Асимметричное шифрование позволяет выдавать токен на одном сервере по закрытому ключу,
    // а проверять на другом сервере по парному открытому ключу.

    private static string $secretKey = '$ecR3tK3Y';

    public static function setSecretKey(string $secretKey) {
        self::$secretKey = $secretKey;
    }

    public static function encode(int $userId, string $profileImgUrl, string $role) : string {

        // Create token header as a JSON string
        $header = json_encode([
            'typ' => 'JWT',
            'alg' => 'HS256'
        ],JSON_UNESCAPED_UNICODE);

        // Create token payload as a JSON string
        $payload = json_encode([
            'id' => $userId,
            'profileImgUrl' => $profileImgUrl,
            'role' => $role,
            'exp' => time() + 60 * 60 * 24 * 30 // время окончания действия текущего токена. PS 30 дней.
        ],JSON_UNESCAPED_UNICODE);

        // Encode Header to Base64Url String
        $base64UrlHeader = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));

        // Encode Payload to Base64Url String
        $base64UrlPayload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($payload));

        // Create Signature Hash --- Другими словами это цифровая подпись.
        // Мы берём хедер и пейлоад и считаем хэш и сравниваем два хэша. EzPz.
        $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, self::$secretKey, true);

        // Encode Signature to Base64Url String
        $base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));

        // Create JWT
        return $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;
    }

    public static function validateToken(string $JWT) : bool {
        $jwtBase64UrlArr = explode('.', $JWT);

        if (count($jwtBase64UrlArr) !== 3) {
            return false;
        }

        $newSignature = hash_hmac('sha256', $jwtBase64UrlArr[0] . "." . $jwtBase64UrlArr[1], self::$secretKey, true);

        // Создаём новую сигнатуру.
        $newBase64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($newSignature));

        // Сверяем с пришедшей.
        if (strcmp($jwtBase64UrlArr[2], $newBase64UrlSignature) !== 0) {
            return false;
        }

        $payload = json_decode(base64_decode($jwtBase64UrlArr[1]),true);

        if (time() > $payload["exp"]) { // Если токен истёк
            return false;
        }

        return true;
    }

    public static function decode(string $JWT) : array {

        if (!self::validateToken($JWT)) {
            throw new \Exception("Invalid JWT");
        }

        $jwtBase64UrlArr = explode('.', $JWT);

        return json_decode(base64_decode($jwtBase64UrlArr[1]),true);
    }
}