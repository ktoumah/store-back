<?php

namespace App\Controller\Api\Security;

use App\Service\AuthenticationServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AuthenticationController extends AbstractController
{
    #[Route(
        '/login',
        name: 'api_login',
        methods: ['POST']
    )]
    public function login(AuthenticationServiceInterface $authenticationService, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $email = $data['email'] ?? '';
        $password = $data['password'] ?? '';

        if (empty($email) || empty($password)) {
            return new JsonResponse(
                ['message' => "Email or password cannnot be empty.", 'token' => null],
                401
            );
        }

        return new JsonResponse($authenticationService->authenticate($email, $password));
    }
}
