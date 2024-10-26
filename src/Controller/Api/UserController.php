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
        '/users/update/{id}',
        name: 'api_users_update',
        methods: ['POST']
    )]
    public function update(User $user, UserServiceInterface $userService, Request $request, ApiHelper $apiHelper): JsonResponse
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

            $userService->update($user, $name, $email, $password);

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
