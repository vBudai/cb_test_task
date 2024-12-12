<?php

namespace App\Entity;

use App\Entity\EntityToArrayMapper\ProjectToArrayMapper;
use App\Repository\ProjectRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ProjectRepository::class)]
class Project
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank, Assert\Length(max: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank, Assert\Length(max: 255)]
    private ?string $customer = null;

    #[ORM\Column]
    #[Assert\Type('boolean')]
    private ?bool $is_close = false;

    /**
     * @var Collection<int, Developer>
     */
    #[ORM\OneToMany(targetEntity: Developer::class, mappedBy: 'project')]
    private Collection $developers;

    public function __construct()
    {
        $this->developers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getCustomer(): ?string
    {
        return $this->customer;
    }

    public function setCustomer(string $customer): static
    {
        $this->customer = $customer;

        return $this;
    }


    public function isClose(): ?bool
    {
        return $this->is_close;
    }

    public function setClose(bool $is_close): static
    {
        $this->is_close = $is_close;

        return $this;
    }

    /**
     * @return Collection<int, Developer>
     */
    public function getDevelopers(): Collection
    {
        return $this->developers;
    }

    public function addDeveloper(Developer $developer): static
    {
        if (!$this->developers->contains($developer)) {
            $this->developers->add($developer);
            $developer->setProject($this);
        }

        return $this;
    }

    public function removeDeveloper(Developer $developer): static
    {
        if ($this->developers->removeElement($developer)) {
            // set the owning side to null (unless already changed)
            if ($developer->getProject() === $this) {
                $developer->setProject(null);
            }
        }

        return $this;
    }
}
