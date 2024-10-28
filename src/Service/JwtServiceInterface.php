<?php

namespace App\Service;

use App\Document\User;

interface JwtServiceInterface
{
    public function getUserByToken(string $token): User;
}
