<?php

namespace App\Service;

use App\Document\Article;
use App\Document\User;
use App\Service\DTO\ArticleDTOTrait;
use Doctrine\ODM\MongoDB\DocumentManager;
use Exception;

class ArticleService implements ArticleServiceInterface
{
    use ArticleDTOTrait;

    public function __construct(
        private DocumentManager $documentManager,
    ) {
    }

    public function userArticles(string $userId): array
    {
        try {
            $author = $this->documentManager->getRepository(User::class)->find($userId);
            $articles = $this->documentManager->getRepository(Article::class)->findBy(['author' => $author]);
            $output = [];
            foreach ($articles as $article) {
                $output[] = $this->formatArticle($article);
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage(), $e->getCode());
        }

        return $output;
    }

    public function add(string $title, string $authorId, string $content): bool
    {
        try {
            $author = $this->documentManager->getRepository(User::class)->find($authorId);
            if (!$author) {
                throw new Exception('Author not found !', 404);
            }
            $article = new Article($title, $author, $content);
            $this->documentManager->persist($article);
            $this->documentManager->flush();
        } catch (Exception $e) {
            throw new Exception($e->getMessage(), $e->getCode());
        }

        return true;
    }

    public function update(Article $article, string $title, string $authorId, string $content): bool
    {
        try {
            $author = $this->documentManager->getRepository(User::class)->find($authorId);
            if (!$author) {
                throw new Exception('Author not found !', 404);
            }
            $article->setTitle($title)
                ->setAuthor($author)
                ->setContent($content);
            $this->documentManager->flush();
        } catch (Exception $e) {
            throw new Exception($e->getMessage(), $e->getCode());
        }

        return true;
    }

    public function delete(Article $article): bool
    {
        try {
            $this->documentManager->remove($article);
            $this->documentManager->flush();
        } catch (Exception $e) {
            throw new Exception($e->getMessage(), $e->getCode());
        }

        return true;
    }
}
