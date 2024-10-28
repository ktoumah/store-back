<?php

namespace App\Utils;

use DateTime;
use Exception;

class ApiHelper
{
    public function formatResponse(?string $message = null, ?string $errorCode = null, ?array $data = []): array
    {
        $resultat["message"] = $message;
        $resultat["errorCode"] = $errorCode;
        $resultat["data"] = $data;

        return $resultat;
    }

    public static function createDateFromEnglishFormat(string $date): DateTime {
        return (new DateTime())->createFromFormat("Y/m/d", $date);
    }

    public static function getTokenFromHeader(string $authHeader): string
    {
        // @phpstan-ignore-next-line
        if (null === $authHeader || !preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
            throw new Exception('No token provided');
        }

        return $matches[1];
    }
}
