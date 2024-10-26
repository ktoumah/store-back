<?php

namespace App\Service;

use App\Document\User;
use App\Security\AuthenticationManagerInterface;
use Doctrine\ODM\MongoDB\DocumentManager;
use Exception;

class AuthenticationService implements AuthenticationServiceInterface
{
    public function __construct(
        private DocumentManager $documentManager,
        private AuthenticationManagerInterface $authenticationManager,
    ) {
    }

    public function authenticate(string $email, string $password): array
    {
        try {
            $user = $this->findUser($email);
            $this->handleAuthentication($user, $password);

            return $this->successfulAuthResponse($user);
        } catch (Exception $e) {
            return $this->errorAuthResponse($e->getMessage(), $e->getCode());
        }
    }

    private function findUser(string $email): User
    {
        $user = $this->documentManager->getRepository(User::class)->findOneBy(['email' => $email]);
        if (empty($user)) {
            throw new Exception('User not found.', 404);
        }

        return $user;
    }

    private function handleAuthentication(User $user, string $password): void
    {
        if (!$this->authenticationManager->checkPasswordValidity($user, $password)) {
            throw new Exception("Email or password is not correct.", 401);
        }
    }

    /**
     * @return array<mixed>
     */
    private function successfulAuthResponse(User $user): array
    {
        $token = $this->authenticationManager->generateTokenForUser($user);
        if (empty($token)) {
            throw new Exception('Cannot generate token !', 401);
        }

        return ['message' => 'Successfull login !', 'code' => 200, 'token' => $token];
    }

    /**
     * @return array<mixed>
     */
    private function errorAuthResponse(string $message, int $code): array
    {
        return ['message' => $message, 'code' => $code, 'token' => null];
    }
}
