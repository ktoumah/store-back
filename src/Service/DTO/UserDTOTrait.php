<?php

namespace App\Service\DTO;

use App\Document\User;

trait UserDTOTrait
{
    public function formatUser(User $user): array {
        return [
            'id' => $user->getId(),
            'name' => $user->getName(),
            'email' => $user->getEmail(),
        ];
    }
}
