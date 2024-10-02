<?php

namespace App\Entity;

use App\Repository\PermissionsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: PermissionsRepository::class)]
class Permissions
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    #[Assert\Type("string")]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\Type("string")]
    private ?string $description = null;

    #[ORM\Column]
    private ?bool $is_active = null;

    #[ORM\OneToMany(mappedBy: 'Permissions', targetEntity: PermissionsUsers::class)]
    private Collection $permissionsUsers;

    #[ORM\OneToMany(mappedBy: 'permissions', targetEntity: PermissionsStructures::class)]
    private Collection $permissionsStructures; 

    public function __construct()
    {
        $this->is_active = true;
        $this->permissionsUsers = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

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

    public function __toString(): string
    {
        return $this->name ?: "";
    }

    /**
     * @return Collection<int, PermissionsUsers>
     */
    public function getPermissionsUsers(): Collection
    {
        return $this->permissionsUsers;
    }

    public function addPermissionsUser(PermissionsUsers $permissionsUser): self
    {
        if (!$this->permissionsUsers->contains($permissionsUser)) {
            $this->permissionsUsers->add($permissionsUser);
            $permissionsUser->setPermissions($this);
        }

        return $this;
    }

    public function removePermissionsUser(PermissionsUsers $permissionsUser): self
    {
        if ($this->permissionsUsers->removeElement($permissionsUser)) {
            // set the owning side to null (unless already changed)
            if ($permissionsUser->getPermissions() === $this) {
                $permissionsUser->setPermissions(null);
            }
        }

        return $this;
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
            $permissionsStructure->setPermissions($this);
        }

        return $this;
    }

    public function removePermissionsStructure(PermissionsStructures $permissionsStructure): self
    {
        if ($this->permissionsStructures->removeElement($permissionsStructure)) {
            // set the owning side to null (unless already changed)
            if ($permissionsStructure->getPermissions() === $this) {
                $permissionsStructure->setPermissions(null);
            }
        }

        return $this;
    }
}
