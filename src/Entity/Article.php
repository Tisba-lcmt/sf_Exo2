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
     *     max= 255,
     *     minMessage="Trop peu de lettres !",
     *     maxMessage="Trop de lettres !"
     * )
     */

    private $title;

    /**
     * @ORM\Column(type="text", nullable=true)
     */

    private $content;

    /**
     * @ORM\Column(type="string", nullable=true)
     */

    private $imageFileName;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     *
     */

    private $publicationDate;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     *
     * @Assert\NotBlank(
     * message="Merci de mettre la Date de Création !"
     * )
     */

    private $creationDate;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     *
     */

    private $isPublished;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="articles")
     *
     * J'ai fais un update de mon Entité Article à l'aide de la ligne de commande
     * php bin/console make:entity, j'ai créé une nouvelle propriété dans Article ($category).
     * Cette propriété représente la relation vers Article (cible Category)
     * La relation est un ManyToOe car je veux avoir une seule catégorie par article, mais
     * qui pourrait contenir plusieurs articles par categorie.
     * Le inversedBy permet de savoir dans l'Entité reliée (donc Category), la propriété
     * qui re-pointe vers l'entité Article (ici c'est la propriété articles)
     */
    private $category;

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

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getImageFileName()
    {
        return $this->imageFileName;
    }

    /**
     * @param mixed $imageFileName
     */
    public function setImageFileName($imageFileName): void
    {
        $this->imageFileName = $imageFileName;
    }
}