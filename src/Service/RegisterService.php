<?php

namespace App\Service;

use App\Document\User;
use App\Security\PasswordUpdaterInterface;
use Doctrine\ODM\MongoDB\DocumentManager;
use Exception;

class RegisterService implements RegisterServiceInterface
{
    public function __construct(
        private DocumentManager $documentManager,
        private PasswordUpdaterInterface $passwordUpdater,
    ) {
    }

    public function register(string $name, string $email, string $password): bool
    {
        try {
            $user = new User($name, $email, [User::ROLE_USER]);
            $user->setPassword($this->passwordUpdater->encodePassword($user, $password));
            $this->documentManager->persist($user);
            $this->documentManager->flush();
        } catch (Exception $e) {
            throw new Exception($e->getMessage(), $e->getCode());
        }

        return true;
    }
}
