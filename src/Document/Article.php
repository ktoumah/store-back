<?php

namespace App\Document;

use DateTime;
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

    #[ODM\Field(type: Type::STRING)]
    private string $content;

    #[ODM\Field(type: Type::DATE)]
    private DateTimeInterface $publicationDate;

    public function __construct(string $title, User $author, string $content)
    {
        $this->title = $title;
        $this->author = $author;
        $this->content = $content;
        $this->publicationDate = new DateTime();
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

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

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
