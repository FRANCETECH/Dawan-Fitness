<?php

namespace App\Entity;

use App\Repository\StructuresRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: StructuresRepository::class)]
class Structures
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    #[Assert\Type("string")]
    private ?string $name = null;

    #[ORM\Column(length: 100)]
    #[Assert\Type("string")]
    private ?string $address = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $phone_number = null;

    #[ORM\Column(options: ["default" => "CURRENT_TIMESTAMP"])]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column]
    private ?bool $is_active = null;

    #[ORM\ManyToMany(targetEntity: Users::class)]
    #[ORM\JoinTable("structures_users")]
    private $users;

    #[ORM\OneToMany(mappedBy: 'structures', targetEntity: PermissionsStructures::class)]
    private Collection $permissionsStructures;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->is_active = true;
        $this->created_at = new \DateTimeImmutable();
        $this->permissionsStructures = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phone_number;
    }

    public function setPhoneNumber(?string $phone_number): self
    {
        $this->phone_number = $phone_number;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function isIsActive(): ?bool
    {
        return $this->is_active;
    }

    public function setIsActive(bool $is_active): self
    {
        $this->is_active = $is_active;

        return $this;
    }

    public function getUsers()
    {
        return $this->users;
    }

    public function setUsers($users): self
    {
        $this->users = $users;

        return $this;
    }

    public function __toString(): string
    {
        return $this->name ?: "";
    }

    /**
     * @return Collection<int, PermissionsStructures>
     */
    public function getPermissionsStructures(): Collection
    {
        return $this->permissionsStructures;
    }

    public function addPermissionsStructure(PermissionsStructures $permissionsStructure): self
    {
        if (!$this->permissionsStructures->contains($permissionsStructure)) {
            $this->permissionsStructures->add($permissionsStructure);
            $permissionsStructure->setStructures($this);
        }

        return $this;
    }

    public function removePermissionsStructure(PermissionsStructures $permissionsStructure): self
    {
        if ($this->permissionsStructures->removeElement($permissionsStructure)) {
            // set the owning side to null (unless already changed)
            if ($permissionsStructure->getStructures() === $this) {
                $permissionsStructure->setStructures(null);
            }
        }

        return $this;
    }
}
