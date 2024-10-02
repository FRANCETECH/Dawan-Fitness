<?php

namespace App\Entity;

use App\Repository\PermissionsStructuresRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PermissionsStructuresRepository::class)]
class PermissionsStructures
{
    #[ORM\Id]
    #[ORM\ManyToOne(inversedBy: 'permissionsStructures')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Permissions $permissions = null;

    #[ORM\Id]
    #[ORM\ManyToOne(inversedBy: 'permissionsStructures')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Structures $structures = null;

    #[ORM\Column]
    private ?bool $is_active = null;

    public function __construct()
    {
        $this->is_active = true;
    }

    public function getPermissions(): ?Permissions
    {
        return $this->permissions;
    }

    public function setPermissions(?Permissions $permissions): self
    {
        $this->permissions = $permissions;

        return $this;
    }

    public function getStructures(): ?Structures
    {
        return $this->structures;
    }

    public function setStructures(?Structures $structures): self
    {
        $this->structures = $structures;

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
}
