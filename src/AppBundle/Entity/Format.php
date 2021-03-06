<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Format
 *
 * @ORM\Table(name="formats")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\FormatRepository")
 */
class Format
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
     * @Assert\NotBlank(message="Название формата обязательно для заполнения")
     */
    private $title;

    /**
     * @var GoodPublication
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\GoodPublication", mappedBy="format")
     */
    private $publications;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Price", mappedBy="format", orphanRemoval=true, cascade={"persist", "remove", "merge"})
     */
    private $prices;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Format", mappedBy="format")
     */
    private $magazines;


    public function __construct()
    {
        $this->publications = new ArrayCollection();
        $this->prices = new ArrayCollection();
        $this->magazines = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->getTitle();
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
     * @return Format
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
     * @return GoodPublication
     */
    public function getPublications()
    {
        return $this->publications;
    }

    /**
     * @param GoodPublication $publications
     */
    public function setPublications($publications)
    {
        $this->publications = $publications;
    }

    /**
     * @return ArrayCollection
     */
    public function getPrices()
    {
        return $this->prices;
    }

    /**
     * @param ArrayCollection $prices
     */
    public function setPrices($prices)
    {
        $this->prices = $prices;
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

