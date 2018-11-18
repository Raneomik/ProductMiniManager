<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 * @Vich\Uploadable
 */
class Product
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(length=255, unique=true)
     */
    private $slug;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="text", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="float")
     */
    private $price;


    /**
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    private $imageName;

    /**
     * @Vich\UploadableField(mapping="product_image", fileNameProperty="imageName")
     * @var File
     */
    private $imageFile;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function setSlug(?string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
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

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setImageFile(?File $imageFile) : self
    {
        $this->imageFile = $imageFile;

        return $this;
    }

    public function getImageFile() : ?File
    {
        return $this->imageFile;
    }

    public function setImageName(?string $imageName) : self
    {
        $this->imageName = $imageName;

        return $this;
    }

    public function getImageName() : ?string
    {
        return $this->imageName;
    }


    public function __toString() : int
    {
        return $this->id;
    }
}
