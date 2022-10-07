<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Component\User\FullNameDto;
use App\Controller\UserCreateAction;
use App\Controller\UserFullNameAction;
use App\Controller\UserGetAdultsAction;
use App\Controller\UserGetMaxAgeAction;
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ApiResource(
    collectionOperations: [
        'get',
        'createUser' => [
            'method' => 'post',
            'path' => '/users',
            'controller' => UserCreateAction::class
        ],
        'fullName' => [
            'method' => 'post',
            'path' => '/users/full-name',
            'input' => FullNameDto::class,
            'controller' => UserFullNameAction::class
        ],
        'auth' => [
            'method' => 'post',
            'path' => '/users/auth',
            'denormalization_context' => ['groups' => ['user:auth']]
        ],
        'maxAge' => [
            'method' => 'get',
            'path' => '/users/max-age',
            'controller' => UserGetMaxAgeAction::class
        ],
        'adults' => [
            'method' => 'get',
            'path' => '/users/adults',
            'controller' => UserGetAdultsAction::class
        ]
    ],
    itemOperations: ['get', 'delete'],
    denormalizationContext: ['groups' => ['user:write']],
    normalizationContext: ['groups' => ['user:read']]
)]
class User implements PasswordAuthenticatedUserInterface, UserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['user:read'])]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['user:read', 'user:write', 'user:auth'])]
    #[Assert\Email]
    private $email;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['user:write', 'user:auth'])]
    private $password;

    #[ORM\Column(type: 'integer', nullable: true)]
    #[Groups(['user:read', 'user:write'])]
    private $age;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getRoles(): array
    {
        return ['ROLE_USER'];
    }

    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    public function getUserIdentifier(): string
    {
        return (string)$this->getId();
    }

    public function getUsername(): string
    {
        return $this->getEmail();
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(?int $age): self
    {
        $this->age = $age;

        return $this;
    }
}
