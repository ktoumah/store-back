<?php

namespace App\Service;

use App\Document\User;
use App\Service\DTO\UserDTOTrait;
use Doctrine\ODM\MongoDB\DocumentManager;
use Exception;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;

class JwtService implements JwtServiceInterface
{
    use UserDTOTrait;

    public function __construct(
        private JWTEncoderInterface $jWTEncoder,
        private DocumentManager $documentManager,
    ) {
        $this->jWTEncoder = $jWTEncoder;
        $this->documentManager = $documentManager;
    }

    public function getUserByToken(string $token): User
    {
        $data = $this->jWTEncoder->decode($token);

        if (null === $data) {
            throw new Exception('Invalid token');
        }

        $username = $data['username'];
        $user = $this->documentManager->getRepository(User::class)->findOneBy(['email' => $username]);

        // @phpstan-ignore-next-line
        if (null === $user) {
            throw new Exception('No user found.');
        }

        return $user;
    }
}
