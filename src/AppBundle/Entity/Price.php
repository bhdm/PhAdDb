<?php

namespace AppBundle\Entity;

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



}

