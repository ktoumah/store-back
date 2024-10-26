<?php

namespace App\Service;

interface RegisterServiceInterface
{
    public function register(string $name, string $email, string $password): bool;
}
