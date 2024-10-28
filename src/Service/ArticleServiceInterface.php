<?php

namespace App\Service;

use App\Document\Article;

interface ArticleServiceInterface
{
    public function add(string $title, string $authorId, string $content): bool;

    public function update(Article $article, string $title, string $authorId, string $content): bool;

    public function userArticles(string $userId): array;

    public function delete(Article $article): bool;
}
