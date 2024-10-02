<?php

namespace App\Entity;

use App\Repository\UsersRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UsersRepository::class)]
#[UniqueEntity(fields: ["email"], message: "Il existe déjà un compte avec cette adresse mail")]
class Users implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(name: "email", type: "string", length: 180, unique: true)]
    #[Assert\Email(message: "Cet email {{ value }} n'est pas valide.")]
    #[Assert\NotBlank(message: "Veuillez renseigner une adresse mail.")]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 50)]
    #[Assert\Type("string")]
    private ?string $name = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $phone_number = null;

    #[ORM\Column(options: ["default" => "CURRENT_TIMESTAMP"])]
    private ?\DateTimeImmutable $created_at = null; 

    #[ORM\Column]
    private ?bool $is_active = null;

    #[ORM\ManyToMany(targetEntity: Structures::class)]
    #[ORM\JoinTable("structures_users")]
    private $structures; 

    #[ORM\OneToMany(mappedBy: "users", targetEntity: PermissionsUsers::class)]
    private Collection $permissionsUsers;

    public function __construct()
    {
        $this->structures = new ArrayCollection();
        $this->is_active = true;
        $this->created_at = new \DateTimeImmutable();
        $this->permissionsUsers = new ArrayCollection();
    }

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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_MANAGER
        $roles[] = 'ROLE_MANAGER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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

    public function getStructures()
    {
        return $this->structures;
    }

    public function setStructures($structures): self
    {
        $this->structures = $structures;

        return $this;
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
            $permissionsUser->setUsers($this);
        }

        return $this;
    }

    public function removePermissionsUser(PermissionsUsers $permissionsUser): self
    {
        if ($this->permissionsUsers->removeElement($permissionsUser)) {
            // set the owning side to null (unless already changed)
            if ($permissionsUser->getUsers() === $this) {
                $permissionsUser->setUsers(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->name ?: "";
    }
}
