<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Nosology
 *
 * @ORM\Table(name="nosologies")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\NosologyRepository")
 */
class Nosology
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
     * @ORM\Column(name="name", type="string", length=255)
     * @Assert\NotBlank(message="Название нозологии обязательно для заполнения")
     */
    private $title;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\GoodPublication", mappedBy="nosologies")
     */
    private $publications;

    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Magazine", mappedBy="nosologies")
     */
    private $magazines;

    public function __construct()
    {
        $this->magazines = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->title;
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
     * @return Nosology
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
     * @return ArrayCollection
     */
    public function getPublications()
    {
        return $this->publications;
    }

    /**
     * @param ArrayCollection
     */
    public function setPublications($publications)
    {
        $this->publications = $publications;
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

