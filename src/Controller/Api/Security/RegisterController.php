<?php

namespace App\Controller\Api\Security;

use App\Service\RegisterServiceInterface;
use App\Utils\ApiHelper;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class RegisterController extends AbstractController
{
    #[Route(
        '/register',
        name: 'api_register',
        methods: ['POST']
    )]
    public function register(RegisterServiceInterface $registerService, Request $request, ApiHelper $apiHelper): JsonResponse
    {
        try {
            $data = json_decode($request->getContent(), true);

            $name = $data['name'] ?? '';
            $email = $data['email'] ?? '';
            $password = $data['password'] ?? '';

            if (empty($name) || empty($email) || empty($password)) {
                return new JsonResponse(
                    $apiHelper->formatResponse("Fields cannot be empty.")
                );
            }

            $registerService->register($name, $email, $password);

            return new JsonResponse(
                $apiHelper->formatResponse("Welcome on board.")
            );
        } catch (Exception $e) {
            return new JsonResponse(
                $apiHelper->formatResponse("An error is occured" . $e->getMessage())
            );
        }
    }
}
