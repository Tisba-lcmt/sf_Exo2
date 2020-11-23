<?php


namespace App\Entity;

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
     * @ORM\Column(type="string")
     */

    private $color;

    /**
     * @ORM\Column(type="datetime")
     */

    private $publicationDate;

    /**
     * @ORM\Column(type="datetime")
     */

    private $creationDate;

    /**
     * @ORM\Column(type="boolean")
     */

    private $isPublished;
}