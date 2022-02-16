<?php

namespace App\Entity;

use App\Repository\ShirtRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;


/**
 * @ORM\Entity(repositoryClass=ShirtRepository::class)
 * @Vich\Uploadable
 */
class Shirt
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotNull(message="El titulo es obligatorio.")
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     * @Assert\Length(min=10, max = 1000)
     * @Assert\NotNull(message="La descripcion es obligatoria.")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $image;

    /**
     * @Vich\UploadableField(mapping="shirt_poster", fileNameProperty="image")
     * @var File
     * @Assert\NotNull(message="La imagen es obligatoria.")
     * @Assert\File(
     *     maxSize = "2048k",
     *     mimeTypes = {"image/jpg", "image/jpeg"},
     *     mimeTypesMessage = "Please upload a valid jpg or jpeg"
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
     * @ORM\Column(type="date")
     * @Assert\NotNull(message="La fecha no puede estar vacia")
     */
    private $upload_date;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="shirts")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotNull()
     */
    private $category;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="shirts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

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

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getUploadDate(): ?\DateTimeInterface
    {
        return $this->upload_date;
    }

    public function setUploadDate(?\DateTimeInterface $upload_date): self
    {
        $this->upload_date = $upload_date;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }


}
