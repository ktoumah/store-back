<?php

namespace App\Security;

use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

interface PasswordUpdaterInterface
{
    public function encodePassword(PasswordAuthenticatedUserInterface $user, string $plainPassword): string;
}
