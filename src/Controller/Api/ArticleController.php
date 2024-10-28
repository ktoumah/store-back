<?php

namespace App\Controller\Api;

use App\Document\Article;
use App\Service\ArticleServiceInterface;
use App\Service\JwtServiceInterface;
use App\Utils\ApiHelper;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    #[Route(
        '/user-articles',
        name: 'api_user_articles',
        methods: ['GET']
    )]
    public function userArticles(
        ArticleServiceInterface $articleService,
        ApiHelper $apiHelper,
        Request $request,
        JwtServiceInterface $jwtService,
    ): JsonResponse
    {
        try {
            $token = ApiHelper::getTokenFromHeader($request->headers->get('Authorization'));
            $articles = $articleService->userArticles($jwtService->getUserByToken($token)->getId());

            return new JsonResponse(
                $apiHelper->formatResponse("All articles.", null, $articles)
            );
        } catch (Exception $e) {
            return new JsonResponse(
                $apiHelper->formatResponse("An error is occured" . $e->getMessage())
            );
        }
    }

    #[Route(
        '/articles',
        name: 'api_articles_add',
        methods: ['POST']
    )]
    public function add(
        ArticleServiceInterface $articleService,
        JwtServiceInterface $jwtService,
        Request $request,
        ApiHelper $apiHelper,
    ): JsonResponse
    {
        try {
            $data = json_decode($request->getContent(), true);

            $title = $data['title'] ?? '';
            $content = $data['content'] ?? '';

            if (empty($title) || empty($content)) {
                return new JsonResponse(
                    $apiHelper->formatResponse("Fields cannot be empty.")
                );
            }
            $token = ApiHelper::getTokenFromHeader($request->headers->get('Authorization'));
            $articleService->add($title, $jwtService->getUserByToken($token)->getId(), $content);

            return new JsonResponse(
                $apiHelper->formatResponse("Article added successfully.")
            );
        } catch (Exception $e) {
            return new JsonResponse(
                $apiHelper->formatResponse("An error is occured" . $e->getMessage())
            );
        }
    }

    #[Route(
        '/articles/{id}',
        name: 'api_articles_update',
        methods: ['PUT']
    )]
    public function update(
        Article $article,
        ArticleServiceInterface $articleService,
        JwtServiceInterface $jwtService,
        Request $request,
        ApiHelper $apiHelper,
    ): JsonResponse
    {
        try {
            $data = json_decode($request->getContent(), true);

            $title = $data['title'] ?? '';
            $content = $data['content'] ?? '';

            if (empty($title) || empty($content)) {
                return new JsonResponse(
                    $apiHelper->formatResponse("Fields cannot be empty.")
                );
            }

            $token = ApiHelper::getTokenFromHeader($request->headers->get('Authorization'));
            $articleService->update($article, $title, $jwtService->getUserByToken($token)->getId(), $content);

            return new JsonResponse(
                $apiHelper->formatResponse("Article updated successfully.")
            );
        } catch (Exception $e) {
            return new JsonResponse(
                $apiHelper->formatResponse("An error is occured" . $e->getMessage())
            );
        }
    }

    #[Route(
        '/articles/{id}',
        name: 'api_articles_delete',
        methods: ['DELETE']
    )]
    public function delete(
        Article $article,
        ArticleServiceInterface $articleService,
        ApiHelper $apiHelper,
    ): JsonResponse
    {
        try {
            $articleService->delete($article);

            return new JsonResponse(
                $apiHelper->formatResponse("Article deleted successfully.")
            );
        } catch (Exception $e) {
            return new JsonResponse(
                $apiHelper->formatResponse("An error is occured" . $e->getMessage())
            );
        }
    }
}
