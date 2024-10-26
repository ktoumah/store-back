<?php

namespace App\Controller\Api;

use App\Document\Article;
use App\Service\ArticleServiceInterface;
use App\Utils\ApiHelper;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    #[Route(
        '/articles',
        name: 'api_articles',
        methods: ['POST']
    )]
    public function all(ArticleServiceInterface $articleService, ApiHelper $apiHelper): JsonResponse
    {
        try {
            $articles = $articleService->all();

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
        '/articles/add',
        name: 'api_articles_add',
        methods: ['POST']
    )]
    public function add(ArticleServiceInterface $articleService, Request $request, ApiHelper $apiHelper): JsonResponse
    {
        try {
            $data = json_decode($request->getContent(), true);

            $title = $data['title'] ?? '';
            $authorId = $data['author_id'] ?? '';
            $publicationDate = $data['publication_date'] ?? '';

            if (empty($title) || empty($authorId) || empty($publicationDate)) {
                return new JsonResponse(
                    $apiHelper->formatResponse("Fields cannot be empty.")
                );
            }

            $articleService->add($title, $authorId, $publicationDate);

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
        '/articles/update/{id}',
        name: 'api_articles_update',
        methods: ['POST']
    )]
    public function update(Article $article, ArticleServiceInterface $articleService, Request $request, ApiHelper $apiHelper): JsonResponse
    {
        try {
            $data = json_decode($request->getContent(), true);

            $title = $data['title'] ?? '';
            $authorId = $data['author_id'] ?? '';
            $publicationDate = $data['publication_date'] ?? '';

            if (empty($title) || empty($authorId) || empty($publicationDate)) {
                return new JsonResponse(
                    $apiHelper->formatResponse("Fields cannot be empty.")
                );
            }

            $articleService->update($article, $title, $authorId, $publicationDate);

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
        '/articles/delete/{id}',
        name: 'api_articles_delete',
        methods: ['POST']
    )]
    public function delete(Article $article, ArticleServiceInterface $articleService, Request $request, ApiHelper $apiHelper): JsonResponse
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
