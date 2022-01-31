<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 */
class Category
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
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=Shirt::class, mappedBy="category")
     */
    private $shirts;

    public function __construct()
    {
        $this->shirts = new ArrayCollection();
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
            $shirt->setCategory($this);
        }

        return $this;
    }

    public function removeShirt(Shirt $shirt): self
    {
        if ($this->shirts->removeElement($shirt)) {
            // set the owning side to null (unless already changed)
            if ($shirt->getCategory() === $this) {
                $shirt->setCategory(null);
            }
        }

        return $this;
    }
}
