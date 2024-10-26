<?php

namespace App\Security;

use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

class PasswordUpdater implements PasswordUpdaterInterface
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function encodePassword(PasswordAuthenticatedUserInterface $user, string $plainPassword): string
    {
        return $this->passwordHasher->hashPassword($user, $plainPassword);
    }
}
