<?php


namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class Category
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */

    private $id;

    /**
     * @ORM\Column(type="string")
     */

    private $title;

    /**
     * @ORM\Column(type="string", nullable=true)
     */

    private $color;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */

    private $publicationDate;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */

    private $creationDate;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */

    private $isPublished;

    /**
     * @ORM\OneToMany(targetEntity=Article::class, mappedBy="category")
     *
     * La propriété articles représente la relation inverse du ManyToOne
     * C'est donc un OneToMany qui veut dire pour une category peut avoir plusieurs articles
     * Il cible l'entité Article. Le mappedBy représente la propriété dans l'entité Article,
     * qui re-pointe vers l'entité Category.
     */
    private $articles;

    /**
     * Dans la méthode constructor (__construct() qui est appelée automatiquement) à chaque
     * fois que la classe est instanciée (donc avec le mot clé "new"). C'est une méthode "Magique" en PHP.
     * Je déclare que la propriété articles qui est un array (un ArrayCollection plus exactement,
     * qui est une sorte d'array avec des super pouvoirs)
     */
    public function __construct()
    {
        $this->articles = new ArrayCollection();
    }

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

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(string $color): self
    {
        $this->color = $color;

        return $this;
    }

    public function getPublicationDate(): ?\DateTimeInterface
    {
        return $this->publicationDate;
    }

    public function setPublicationDate(\DateTimeInterface $publicationDate): self
    {
        $this->publicationDate = $publicationDate;

        return $this;
    }

    public function getCreationDate(): ?\DateTimeInterface
    {
        return $this->creationDate;
    }

    public function setCreationDate(\DateTimeInterface $creationDate): self
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

    /**
     * @return Collection|Article[]
     */
    public function getArticles(): Collection
    {
        return $this->articles;
    }

    /**
     * La méthode addArticle permet d'ajouter pour la catégorie
     * un article, sans écraser les autres (vu que la propriété
     * articles est un tableau, on peut avoir plusieurs articles)
     */
    public function addArticle(Article $article): self
    {
        if (!$this->articles->contains($article)) {
            $this->articles[] = $article;
            $article->setCategory($this);
        }

        return $this;
    }

    /**
     * Cette méthode permet de supprimer un article, sans supprimer les autres.
     */
    public function removeArticle(Article $article): self
    {
        if ($this->articles->removeElement($article)) {
            // set the owning side to null (unless already changed)
            if ($article->getCategory() === $this) {
                $article->setCategory(null);
            }
        }

        return $this;
    }
}