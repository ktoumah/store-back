<?php

namespace App\Document;

use DateTimeInterface;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Doctrine\ODM\MongoDB\Types\Type;

#[MongoDB\Document(collection: 'articles')]
class Article
{
    #[ODM\Id]
    private string $id;

    #[ODM\Field(type: Type::STRING)]
    private string $title;

    #[ODM\ReferenceOne(targetDocument: User::class)]
    private User $author;

    #[ODM\Field(type: Type::DATE)]
    private DateTimeInterface $publicationDate;

    public function __construct(string $title, User $author, DateTimeInterface $publicationDate)
    {
        $this->title = $title;
        $this->author = $author;
        $this->publicationDate = $publicationDate;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getAuthor(): User
    {
        return $this->author;
    }

    public function setAuthor(User $author): static
    {
        $this->author = $author;

        return $this;
    }

    public function getPublicationDate(): DateTimeInterface
    {
        return $this->publicationDate;
    }

    public function setPublicationDate(DateTimeInterface $publicationDate): static
    {
        $this->publicationDate = $publicationDate;

        return $this;
    }
}
