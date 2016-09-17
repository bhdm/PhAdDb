<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * GoodPublication
 *
 * @ORM\Table(name="goods_publications")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\GoodPublicationRepository")
 */
class GoodPublication
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
     * @var Good
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Good", inversedBy="publications")
     */
    private $good;

    /**
     * @var Format
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Format", inversedBy="publications")
     */
    private $format;

    /**
     * @return GoodDesign
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\GoodDesign", inversedBy="publications")
     * @ORM\JoinColumn(name="des_id", referencedColumnName="id")
     */
    private $design;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Nosology", inversedBy="publications")
     * @ORM\JoinTable(name="publications_nosologies",
     *      joinColumns={@ORM\JoinColumn(name="p_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="n_id", referencedColumnName="id")}
     *      )
     */
    private $nosologies;

    public function __construct()
    {
        $this->nosologies = new ArrayCollection();
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
     * @return Good
     */
    public function getGood()
    {
        return $this->good;
    }

    /**
     * @param Good $good
     */
    public function setGood($good)
    {
        $this->good = $good;
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
    public function getDesign()
    {
        return $this->design;
    }

    /**
     * @param mixed $design
     */
    public function setDesign($design)
    {
        $this->design = $design;
    }

    /**
     * @return ArrayCollection
     */
    public function getNosologies()
    {
        return $this->nosologies;
    }

    /**
     * @param ArrayCollection $nosologies
     */
    public function setNosologies($nosologies)
    {
        $this->nosologies = $nosologies;
    }



}

