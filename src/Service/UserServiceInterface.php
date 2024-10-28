<?php

namespace App\Service;

use App\Document\User;

interface UserServiceInterface
{
    public function update(User $user, string $name, string $email): bool;

    public function getUserInformations(string $token): array;
}
