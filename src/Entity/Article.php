<?php


namespace App\Entity;



use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()\Entity()
 */

class Article
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */

    private $id;

    /**
     * @ORM\Column(type="string")
     *
     * @Assert\NotBlank(
     *     message="Merci de remplir le titre !"
     * )
     *
     * @Assert\Length(
     *     min= 4,
     *     max= 15,
     *     minMessage="Trop peu de lettres !",
     *     maxMessage="Trop de lettres !"
     * )
     */

    private $title;

    /**
     * @ORM\Column(type="text")
     *
     * @Assert\Length(
     *     min= 4,
     *     max= 50,
     *     minMessage="Trop peu de lettres !",
     *     maxMessage="Trop de lettres !"
     * )
     */

    private $content;

    /**
     * @ORM\Column(type="string")
     *
     * @Assert\NotBlank(
     *     message="Merci de mettre l'URL de l'image !"
     * )
     */

    private $image;

    /**
     * @ORM\Column(type="datetime")
     *
     */

    private $publicationDate;

    /**
     * @ORM\Column(type="datetime")
     *
     * @Assert\NotBlank(
     * message="Merci de mettre la Date de Création !"
     * )
     */

    private $creationDate;

    /**
     * @ORM\Column(type="boolean")
     *
     */

    private $isPublished;

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

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getPublicationDate(): ?\DateTimeInterface
    {
        return $this->publicationDate;
    }

    public function setPublicationDate( $publicationDate): self
    {
        $this->publicationDate = $publicationDate;

        return $this;
    }

    public function getCreationDate(): ?\DateTimeInterface
    {
        return $this->creationDate;
    }

    public function setCreationDate( $creationDate): self
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    public function getIsPublished(): ?bool
    {
        return $this->isPublished;
    }

    public function setIsPublished(bool $isPublished): self
    {
        $this->isPublished = $isPublished;

        return $this;
    }

}