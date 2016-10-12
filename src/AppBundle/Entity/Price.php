<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Price
 *
 * @ORM\Table(name="prices")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PriceRepository")
 */
class Price
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
     * @var int
     *
     * @ORM\Column(name="year", type="integer")
    * @Assert\NotBlank(message="Год обязателен для заполнения")
     */
    private $year;

    /**
     * @var int
     *
     * @ORM\Column(name="price", type="integer")
     * @Assert\NotBlank(message="Цена обязательна для заполнения")
     */
    private $price;

    /**
     * @var Magazine
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Magazine", inversedBy="prices")
     * @ORM\JoinColumn(name="mag_id", referencedColumnName="id")
     */
    private $magazine;

    /**
     * @var Format
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Format", inversedBy="prices")
     */
    private $format;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Позиция обязательна для заполнения")
     */
    private $position;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $color;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Format")
     */
    private $publicationBonus;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $nds;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Price", mappedBy="price")
     */
    private $goods;


    public function __construct()
    {
        $this->color = false;
        $this->goodsr = new ArrayCollection();
        $this->nds = false;
    }

    public function __toString()
    {
        return $this->getMagazine().' '.$this->getFormat().' '.$this->getPrice().'руб ';
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
     * Set year
     *
     * @param integer $year
     *
     * @return Price
     */
    public function setYear($year)
    {
        $this->year = $year;

        return $this;
    }

    /**
     * Get year
     *
     * @return int
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * @return int
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param int $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * @return Magazine
     */
    public function getMagazine()
    {
        return $this->magazine;
    }

    /**
     * @param Magazine $magazine
     */
    public function setMagazine($magazine)
    {
        $this->magazine = $magazine;
    }

    /**
     * @return Format
     */
    public function getFormat()
    {
        return $this->format;
    }

    /**
     * @param Format $format
     */
    public function setFormat($format)
    {
        $this->format = $format;
    }

    /**
     * @return mixed
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @param mixed $position
     */
    public function setPosition($position)
    {
        $this->position = $position;
    }

    /**
     * @return mixed
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * @param mixed $color
     */
    public function setColor($color)
    {
        $this->color = $color;
    }

    /**
     * @return mixed
     */
    public function getPublicationBonus()
    {
        return $this->publicationBonus;
    }

    /**
     * @param mixed $publicationBonus
     */
    public function setPublicationBonus($publicationBonus)
    {
        $this->publicationBonus = $publicationBonus;
    }

    /**
     * @return mixed
     */
    public function getNds()
    {
        return $this->nds;
    }

    /**
     * @param mixed $nds
     */
    public function setNds($nds)
    {
        $this->nds = $nds;
    }

    /**
     * @return ArrayCollection
     */
    public function getGoodsr()
    {
        return $this->goodsr;
    }

    /**
     * @param ArrayCollection $goodsr
     */
    public function setGoodsr($goodsr)
    {
        $this->goodsr = $goodsr;
    }

    /**
     * @return mixed
     */
    public function getGoods()
    {
        return $this->goods;
    }

    /**
     * @param mixed $goods
     */
    public function setGoods($goods)
    {
        $this->goods = $goods;
    }



}

