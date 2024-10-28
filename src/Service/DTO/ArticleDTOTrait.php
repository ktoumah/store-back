<?php

namespace App\Service\DTO;

use App\Document\Article;

trait ArticleDTOTrait
{
    public function formatArticle(Article $article): array {
        return [
            'id' => $article->getId(),
            'title' => $article->getTitle(),
            'content' => $article->getContent(),
            'publication_date' => $article->getPublicationDate()->format('Y/m/d'),
        ];
    }
}
