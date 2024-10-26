<?php

namespace App\Service\DTO;

use App\Document\Article;

trait ArticleDTOTrait
{
    public function formatArticle(Article $article): array {
        return [
            'title' => $article->getTitle(),
            'publication_date' => $article->getPublicationDate()->format('Y/m/d'),
        ];
    }
}
