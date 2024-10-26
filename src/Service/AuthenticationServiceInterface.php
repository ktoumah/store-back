<?php

namespace App\Service;

interface AuthenticationServiceInterface
{
    public function authenticate(string $email, string $password): array;
}
