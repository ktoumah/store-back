<?php

namespace App\Service;

use App\Document\Article;

interface ArticleServiceInterface
{
    public function add(string $title, string $authorId, string $publicationDate): bool;

    public function update(Article $article, string $title, string $authorId, string $publicationDate): bool;

    public function all(): array;

    public function delete(Article $article): bool;
}
