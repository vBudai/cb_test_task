<?php

namespace App\Entity;

use App\Repository\DeveloperRepository;
use App\Validator\DeveloperProject;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: DeveloperRepository::class)]
class Developer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[
        Assert\NotBlank,
        Assert\Length(max: 255)
    ]
    private ?string $fullName = null;

    #[ORM\Column(length: 255)]
    #[
        Assert\NotBlank,
        Assert\Length(min: 10, max: 255)
    ]
    private ?string $post = null;

    #[ORM\Column(length: 255)]
    #[
        Assert\NotBlank,
        Assert\Length(max: 255),
        Assert\Regex(
            pattern: '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/',
            message: 'Wrong email format'
        )
    ]
    private ?string $email = null;

    #[ORM\Column(length: 11)]
    #[
        Assert\NotBlank,
        Assert\Length(max: 11),
        Assert\Regex(
            pattern: '/^\d{11}$/',
            message: 'Phone can only be 11 digits',
            match: true
        )
    ]
    private ?string $phone = null;

    #[ORM\ManyToOne(inversedBy: 'developers')]
    #[ORM\JoinColumn(name: "project_id", referencedColumnName: "id", onDelete: "SET NULL")]
    private ?Project $project = null;

    #[ORM\Column(type: Types::SMALLINT)]
    #[
        Assert\NotBlank,
        Assert\Positive,
        Assert\Length(min: 1, max: 32767)
    ]
    private ?int $age = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFullName(): ?string
    {
        return $this->fullName;
    }

    public function setFullName(string $fullName): static
    {
        $this->fullName = $fullName;

        return $this;
    }

    public function getPost(): ?string
    {
        return $this->post;
    }

    public function setPost(string $post): static
    {
        $this->post = $post;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    public function getProject(): ?Project
    {
        return $this->project;
    }

    public function setProject(?Project $project): static
    {
        $this->project = $project;

        return $this;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(?int $age): static
    {
        $this->age = $age;

        return $this;
    }
}
