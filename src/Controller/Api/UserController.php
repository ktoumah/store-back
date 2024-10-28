<?php

namespace App\Controller\Api;

use App\Document\User;
use App\Service\UserServiceInterface;
use App\Utils\ApiHelper;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route(
        '/users/get-informations',
        name: 'api_users_get_informations',
        methods: ['GET']
    )]
    public function getInformations(UserServiceInterface $userService, Request $request, ApiHelper $apiHelper): JsonResponse
    {
        try {
            $authHeader = $request->headers->get('Authorization');
            if (null === $authHeader || !preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
                throw new Exception('No token provided');
            }

            $token = $matches[1];

            return new JsonResponse(
                $apiHelper->formatResponse(
                    "User informations retrieved successfully.",
                    null,
                    $userService->getUserInformations($token)
                )
            );
        } catch (Exception $e) {
            return new JsonResponse(
                $apiHelper->formatResponse("An error is occured" . $e->getMessage())
            );
        }
    }

    #[Route(
        '/users/{id}',
        name: 'api_users_update',
        methods: ['PUT']
    )]
    public function update(User $user, UserServiceInterface $userService, Request $request, ApiHelper $apiHelper): JsonResponse
    {
        try {
            $data = json_decode($request->getContent(), true);

            $name = $data['name'] ?? '';
            $email = $data['email'] ?? '';

            if (empty($name) || empty($email)) {
                return new JsonResponse(
                    $apiHelper->formatResponse("Fields cannot be empty.")
                );
            }

            $userService->update($user, $name, $email);

            return new JsonResponse(
                $apiHelper->formatResponse("Your informations have been updated successfully.")
            );
        } catch (Exception $e) {
            return new JsonResponse(
                $apiHelper->formatResponse("An error is occured" . $e->getMessage())
            );
        }
    }
}
