<?php

namespace App\Service\Validator\Controller;

use Exception;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class AuthenticationValidator
{
    public function __construct(private ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    public function validateLogin(array $data): mixed
    {
        $constraints = new Assert\Collection([
            'email' => [
                new Assert\NotBlank(['message' => 'Email cannot be empty.']),
                new Assert\Email(['message' => 'Invalid email format.']),
            ],
            'password' => [
                new Assert\NotBlank(['message' => 'Password cannot be empty.']),
                new Assert\Length([
                    'min' => 6,
                    'minMessage' => 'Password must be at least {{ limit }} characters long.',
                ]),
            ],
        ]);

        $violations = $this->validator->validate($data, $constraints);

        if (count($violations) > 0) {
            $errors = [];
            foreach ($violations as $violation) {
                $errors[$violation->getPropertyPath()] = $violation->getMessage();
            }

            throw new Exception(implode(";", $errors));
        }

        return true;
    }
}
