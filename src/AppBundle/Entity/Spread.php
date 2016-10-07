<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Spread
 *
 * @ORM\Table(name="spread")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SpreadRepository")
 */
class Spread
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;


    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Spread", mappedBy="spread")
     */
    private $magazines;


    public function __toString()
    {
        return $this->getTitle();
    }

    public function __construct()
    {
        $this->magazines = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Spread
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return mixed
     */
    public function getMagazines()
    {
        return $this->magazines;
    }

    /**
     * @param mixed $magazines
     */
    public function setMagazines($magazines)
    {
        $this->magazines = $magazines;
    }


}

