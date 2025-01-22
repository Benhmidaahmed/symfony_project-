<?php

namespace App\Entity;

use App\Repository\NewsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;

use Vich\UploaderBundle\Mapping\Annotation as Vich;  // Assurez-vous d'avoir cette importation

#[ORM\Entity(repositoryClass: NewsRepository::class)]


#[Vich\Uploadable]
class News
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;
    #[ORM\Column(name: 'image_name', type: 'string', length: 255, nullable: true)]
    private ?string $imageName = null; // Gardez la propriété comme imageName
    
   /**
 * @Vich\UploadableField(mapping="newsImage", fileNameProperty="imageName")
 * @var File|null
 */
private ?File $imageFile = null;




    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $createAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $updatedAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    public function setImageName(?string $imageName): static
    {
        $this->imageName = $imageName;

        return $this;
    }

    public function getCreateAt(): ?\DateTimeInterface
    {
        return $this->createAt;
    }

    public function setCreateAt(\DateTimeInterface $createAt): static
    {
        $this->createAt = $createAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
    public function setImageFile(File $image = null)
{
    $this->imageFile = $image;

    // VERY IMPORTANT:
    // It is required that at least one field changes if you are using Doctrine,
    // otherwise the event listeners won't be called and the file is lost
    if ($image) {
        // if 'updatedAt' is not defined in your entity, use another property
        $this->updatedAt = new \DateTime('now');
    }
}

public function getImageFile()
{
    return $this->imageFile;
}

}
