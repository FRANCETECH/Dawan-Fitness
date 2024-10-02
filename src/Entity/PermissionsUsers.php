<?php

namespace App\Entity;

use App\Repository\PermissionsUsersRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PermissionsUsersRepository::class)]
class PermissionsUsers
{
    #[ORM\Id]
    #[ORM\ManyToOne(inversedBy: 'permissionsUsers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Permissions $Permissions = null;

    #[ORM\Id]
    #[ORM\ManyToOne(inversedBy: 'permissionsUsers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Users $users = null;

    #[ORM\Column]
    private ?bool $is_active = null;

    public function __construct()
    {
        $this->is_active = true;
    }

    public function getPermissions(): ?Permissions
    {
        return $this->Permissions;
    }

    public function setPermissions(?Permissions $Permissions): self
    {
        $this->Permissions = $Permissions;

        return $this;
    }

    public function getUsers(): ?Users
    {
        return $this->users;
    }

    public function setUsers(?Users $users): self
    {
        $this->users = $users;

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
