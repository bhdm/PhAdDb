<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Magazine
 *
 * @ORM\Table(name="magazins")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MagazineRepository")
 */
class Magazine
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
     * @Assert\NotBlank(message="Название магазина обязательно для заполнения")
     */
    private $title;

    /**
     * @var int
     *
     * @ORM\Column(name="circulation", type="integer")
     */
    private $circulation;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\MagazinePublication", mappedBy="magazine")
     */
    private $publications;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Price", mappedBy="magazine")
     */
    private $prices;

    /**
     * @var PublishingHouse
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\PublishingHouse", inversedBy="magazines")
     * @ORM\JoinColumn(name="house_id", referencedColumnName="id")
     */
    private $house;

    public function __construct()
    {
        $this->publications = new ArrayCollection();
        $this->prices = new ArrayCollection();
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
     * @return Magazine
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
     * Set circulation
     *
     * @param integer $circulation
     *
     * @return Magazine
     */
    public function setCirculation($circulation)
    {
        $this->circulation = $circulation;

        return $this;
    }

    /**
     * Get circulation
     *
     * @return int
     */
    public function getCirculation()
    {
        return $this->circulation;
    }

    /**
     * @return MagazinePublication
     */
    public function getPublications()
    {
        return $this->publications;
    }

    /**
     * @param MagazinePublication $publications
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



}

