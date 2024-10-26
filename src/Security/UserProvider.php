<?php

namespace App\Security;

use App\Document\User;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class UserProvider implements UserProviderInterface
{
    public function __construct(
        private readonly DocumentManager $documentManager,
    ) {
    }

    public function loadUserByIdentifier(string $identifier): UserInterface
    {
        $user = $this->documentManager->getRepository(User::class)->findOneBy(['email' => $identifier]);

        if (null === $user) {
            throw new UserNotFoundException(sprintf('User with identifier "%s" not found.', $identifier));
        }

        return $user;
    }

    public function refreshUser(UserInterface $user): UserInterface
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', get_class($user)));
        }

        return $this->loadUserByIdentifier($user->getEmail());
    }

    public function supportsClass(string $class): bool
    {
        return User::class === $class;
    }
}
