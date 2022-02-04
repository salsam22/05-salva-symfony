<?php

namespace App\Entity;

use App\Repository\UsersRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UsersRepository::class)
 */
class Users
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $avatar;

    /**
     * @ORM\OneToMany(targetEntity=Shirt::class, mappedBy="user")
     */
    private $shirts;

    /**
     * @ORM\ManyToOne(targetEntity=Rol::class, inversedBy="users")
     * @ORM\JoinColumn(nullable=false)
     */
    private $rol;

    public function __construct()
    {
        $this->shirts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $email): self
    {
        $this->username = $email;

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

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setAvatar(?string $avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }

    /**
     * @return Collection|Shirt[]
     */
    public function getShirts(): Collection
    {
        return $this->shirts;
    }

    public function addShirt(Shirt $shirt): self
    {
        if (!$this->shirts->contains($shirt)) {
            $this->shirts[] = $shirt;
            $shirt->setUser($this);
        }

        return $this;
    }

    public function removeShirt(Shirt $shirt): self
    {
        if ($this->shirts->removeElement($shirt)) {
            // set the owning side to null (unless already changed)
            if ($shirt->getUser() === $this) {
                $shirt->setUser(null);
            }
        }

        return $this;
    }

    public function getRol(): ?Rol
    {
        return $this->rol;
    }

    public function setRol(?Rol $rol): self
    {
        $this->rol = $rol;

        return $this;
    }
}
