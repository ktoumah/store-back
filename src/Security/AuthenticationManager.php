<?php

namespace App\Security;

use App\Document\User;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AuthenticationManager implements AuthenticationManagerInterface
{
    public function __construct(
        private UserPasswordHasherInterface $passwordHasher,
        private JWTTokenManagerInterface $jwtManager,
    ) {
    }

    public function checkPasswordValidity(User $user, string $password): bool
    {
        return $this->passwordHasher->isPasswordValid($user, $password);
    }

    public function generateTokenForUser(User $user): string
    {
        return $this->jwtManager->create($user);
    }
}
