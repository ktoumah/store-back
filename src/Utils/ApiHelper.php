<?php

namespace App\Utils;

use DateTime;

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
}
