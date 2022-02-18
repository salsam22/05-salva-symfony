<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(fields={"username"}, message="There is already an account with this username")
 * @Vich\Uploadable
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotNull(message="Name is required.")
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotNull(message="Email is required.")
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotNull(message="Username is required.")
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotNull(message="Password is required.")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $avatar;

    /**
     * @Vich\UploadableField(mapping="user_avatar", fileNameProperty="avatar")
     * @var File
     * @Assert\File(
     *     maxSize = "1024k",
     *     mimeTypes = {"image/jpg", "image/jpeg", "image/png"},
     *     mimeTypesMessage = "Please upload a valid jpg, jpeg or png."
     * )
     */
    private $imagesFile;

    /**
     * @return File
     */
    public function getImagesFile(): ?File
    {
        return $this->imagesFile;
    }

    public function setImagesFile(File $image2 = null)
    {
        $this->imagesFile = $image2;

        // VERY IMPORTANT:
        // It is required that at least one field changes if you are using Doctrine,
        // otherwise the event listeners won't be called and the file is lost
        if ($image2) {
            // if 'updatedAt' is not defined in your entity, use another property
            $this->updatedAt = new \DateTimeImmutable('now');
        }
    }

    /**
     * @ORM\OneToMany(targetEntity=Shirt::class, mappedBy="user")
     */
    private $shirts;

    /**
     * @ORM\ManyToOne(targetEntity=Rol::class, inversedBy="users")
     * @ORM\JoinColumn(nullable=false)
     */
    private $rol;

    /**
     * @ORM\OneToMany(targetEntity=Basket::class, mappedBy="User", orphanRemoval=true)
     */
    private $baskets;

    public function __construct()
    {
        $this->shirts = new ArrayCollection();
        $this->baskets = new ArrayCollection();
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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

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

    public function getRoles()
    {
        return [$this->getRol()->getName()];
    }

    public function getSalt()
    {
        return null;
    }

    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    public function getUserIdentifier(): string
    {
        return $this->getUsername();
    }

    /**
     * @return Collection<int, Basket>
     */
    public function getBaskets(): Collection
    {
        return $this->baskets;
    }

    public function addBasket(Basket $basket): self
    {
        if (!$this->baskets->contains($basket)) {
            $this->baskets[] = $basket;
            $basket->setUser($this);
        }

        return $this;
    }

    public function removeBasket(Basket $basket): self
    {
        if ($this->baskets->removeElement($basket)) {
            // set the owning side to null (unless already changed)
            if ($basket->getUser() === $this) {
                $basket->setUser(null);
            }
        }

        return $this;
    }
}
