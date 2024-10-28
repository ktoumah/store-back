<?php

namespace App\Service;

use App\Document\User;
use App\Service\DTO\UserDTOTrait;
use Doctrine\ODM\MongoDB\DocumentManager;
use Exception;

class UserService implements UserServiceInterface
{
    use UserDTOTrait;

    public function __construct(
        private DocumentManager $documentManager,
        private JwtServiceInterface $jwtService,
    ) {
    }

    public function update(User $user, string $name, string $email): bool
    {
        try {
            $user->setName($name)
                ->setEmail($email);
            $this->documentManager->flush();
        } catch (Exception $e) {
            throw new Exception($e->getMessage(), $e->getCode());
        }

        return true;
    }

    public function getUserInformations(string $token): array
    {
        $user = $this->jwtService->getUserByToken($token);

        return $this->formatUser($user);
    }
}
