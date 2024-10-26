<?php

namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Doctrine\ODM\MongoDB\Types\Type;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[MongoDB\Document(collection: 'users')]
#[MongoDB\Index(keys: ['email' => 1], options: ['unique' => true])]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    public const ROLE_USER = "ROLE_USER";
    public const ROLE_ADMIN = "ROLE_ADMIN";

    #[ODM\Id]
    private string $id;

    #[ODM\Field(type: Type::STRING)]
    private string $name;

    #[ODM\Field(type: Type::STRING)]
    private string $email;

    #[ODM\Field(type: Type::COLLECTION)]
    private array $roles = [];

    #[ODM\Field(type: Type::STRING)]
    private ?string $password = null;

    public function __construct(string $name, string $email, array $roles)
    {
        $this->name = $name;
        $this->email = $email;
        $this->roles = $roles;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getUserIdentifier(): string
    {
        return $this->email;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;

        $roles[] = self::ROLE_USER;

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }
}
