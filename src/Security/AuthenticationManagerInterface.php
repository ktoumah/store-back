<?php

namespace App\Security;

use App\Document\User;

interface AuthenticationManagerInterface
{
    public function checkPasswordValidity(User $user, string $password): bool;

    public function generateTokenForUser(User $user): string;
}
