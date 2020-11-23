<?php


namespace App\Entity;



use Doctrine\ORM\Mapping as ORM;

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
     */

    private $title;

    /**
     * @ORM\Column(type="text")
     */

    private $content;

    /**
     * @ORM\Column(type="string")
     */

    private $image;

    /**
     * @ORM\Column(type="datetime")
     */

    private $publicationDate;

    /**
     * @ORM\Column(type="datetime")
     */

    private $CreationDate;

    /**
     * @ORM\Column(type="boolean")
     */

    private $isPublished;

}