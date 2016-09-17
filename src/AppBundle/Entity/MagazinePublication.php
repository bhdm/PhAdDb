<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * MagazinePublication
 *
 * @ORM\Table(name="magazins_publications")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MagazinePublicationRepository")
 */
class MagazinePublication
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
     * @ORM\Column(name="number", type="string", length=255)
     * @Assert\NotBlank(message="Номер обязателен для заполнения")
     */
    private $number;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     * @Assert\NotBlank(message="Дата обязательна для заполнения")
     */
    private $date;

    /**
     * @var Magazine
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Magazine", inversedBy="publications")
     * @ORM\JoinColumn(name="magazin_id", referencedColumnName="id")
     */
    private $magazine;


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
     * Set number
     *
     * @param string $number
     *
     * @return MagazinePublication
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Get number
     *
     * @return string
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return MagazinePublication
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
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


}

