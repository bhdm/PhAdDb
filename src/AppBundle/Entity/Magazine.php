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
     * @Assert\NotBlank(message="Название журнала обязательно для заполнения")
     */
    private $title;

    /**
     * @var int
     *
     * @ORM\Column(name="circulation", type="integer")
     * @Assert\NotBlank(message="Тираж обязателен для заполнения")
     */
    private $circulation;

    /**
     * @var string
     *
     * @ORM\Column(name="periodicity", type="string", length=255, nullable=true)
     */
    private $periodicity;

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

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $bak;

    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Nosology", inversedBy="magazines")
     */
    private $nosologies;

    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Spread", inversedBy="magazines")
     */
    private $spread;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Format", inversedBy="magazines")
     */
    private $format;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $impactFactor;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $mainEditor;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $audience;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $citationSystem;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updated;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Magazine", mappedBy="magazine")
     */
    private $mediaplans;


    public function __construct()
    {
        $this->updated = new \DateTime();
        $this->publications = new ArrayCollection();
        $this->spread = new ArrayCollection();
        $this->nosologies = new ArrayCollection();
        $this->prices = new ArrayCollection();
        $this->mediaplans = new ArrayCollection();
        $this->bak = false;
        $this->citationSystem = false;
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

    /**
     * @return PublishingHouse
     */
    public function getHouse()
    {
        return $this->house;
    }

    /**
     * @param PublishingHouse $house
     */
    public function setHouse($house)
    {
        $this->house = $house;
    }

    /**
     * @return string
     */
    public function getPeriodicity()
    {
        return $this->periodicity;
    }

    /**
     * @param string $periodicity
     */
    public function setPeriodicity($periodicity)
    {
        $this->periodicity = $periodicity;
    }

    /**
     * @return mixed
     */
    public function getNosologies()
    {
        return $this->nosologies;
    }

    /**
     * @param mixed $nosologies
     */
    public function setNosologies($nosologies)
    {
        $this->nosologies = $nosologies;
    }

    /**
     * @return mixed
     */
    public function getBak()
    {
        return $this->bak;
    }

    /**
     * @param mixed $bak
     */
    public function setBak($bak)
    {
        $this->bak = $bak;
    }

    /**
     * @return mixed
     */
    public function getFormat()
    {
        return $this->format;
    }

    /**
     * @param mixed $format
     */
    public function setFormat($format)
    {
        $this->format = $format;
    }

    /**
     * @return mixed
     */
    public function getSpread()
    {
        return $this->spread;
    }

    public function addSpread($spread){
        $this->spread->add($spread);
    }

    public function removeSpread($spread){
        $this->spread->removeElement($spread);
    }

    /**
     * @param mixed $spread
     */
    public function setSpread($spread)
    {
        $this->spread = $spread;
    }

    /**
     * @return mixed
     */
    public function getImpactFactor()
    {
        return $this->impactFactor;
    }

    /**
     * @param mixed $impactFactor
     */
    public function setImpactFactor($impactFactor)
    {
        $this->impactFactor = $impactFactor;
    }

    /**
     * @return mixed
     */
    public function getCitationSystem()
    {
        return $this->citationSystem;
    }

    /**
     * @param mixed $citationSystem
     */
    public function setCitationSystem($citationSystem)
    {
        $this->citationSystem = $citationSystem;
    }

    /**
     * @return mixed
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * @param mixed $updated
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;
    }

    /**
     * @ORM\PreUpdate()
     */
    public function preUpdate(){
        $this->updated = new \DateTime();
    }

    /**
     * @return mixed
     */
    public function getMainEditor()
    {
        return $this->mainEditor;
    }

    /**
     * @param mixed $mainEditor
     */
    public function setMainEditor($mainEditor)
    {
        $this->mainEditor = $mainEditor;
    }

    /**
     * @return mixed
     */
    public function getAudience()
    {
        return $this->audience;
    }

    /**
     * @param mixed $audience
     */
    public function setAudience($audience)
    {
        $this->audience = $audience;
    }

    /**
     * @return mixed
     */
    public function getMediaplans()
    {
        return $this->mediaplans;
    }

    /**
     * @param mixed $mediaplans
     */
    public function setMediaplans($mediaplans)
    {
        $this->mediaplans = $mediaplans;
    }


}

