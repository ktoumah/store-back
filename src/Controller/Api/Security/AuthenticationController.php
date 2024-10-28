<?php

namespace App\Controller\Api\Security;

use App\Service\AuthenticationServiceInterface;
use App\Service\Validator\Controller\AuthenticationValidator;
use App\Utils\ApiHelper;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AuthenticationController extends AbstractController
{
    #[Route(
        '/login',
        name: 'api_login',
        methods: ['POST']
    )]
    public function login(
        AuthenticationServiceInterface $authenticationService,
        AuthenticationValidator $authenticationValidator,
        Request $request,
        ApiHelper $apiHelper,
    ): JsonResponse
    {
        try {
            $data = json_decode($request->getContent(), true);
            $authenticationValidator->validateLogin($data);
            $email = $data['email'] ?? '';
            $password = $data['password'] ?? '';
        } catch (Exception $e) {
            return new JsonResponse(
                $apiHelper->formatResponse("An error is occured: " . $e->getMessage()),
                Response::HTTP_BAD_REQUEST
            );
        }

        return new JsonResponse($authenticationService->authenticate($email, $password));
    }
}
