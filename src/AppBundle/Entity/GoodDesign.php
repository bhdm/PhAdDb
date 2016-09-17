<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * GoodDesign
 *
 * @ORM\Table(name="goods_designs")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\GoodDesignRepository")
 */
class GoodDesign
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
     * @ORM\Column(name="file", type="string", length=255)
     * @Assert\NotBlank(message="Файл обязателен для заполнения")
     * @Assert\File(maxSize="3M", maxSizeMessage="Размер файла не должен превышать 3M")
     */
    private $file;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     * @Assert\NotBlank(message="Название обязательно для заполнения")
     */
    private $title;

    /**
     * @var Good
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Good", inversedBy="designs")
     */
    private $good;

    /**
     * @var GoodPublication
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\GoodPublication", mappedBy="design")
     */
    private $publications;

    public function __construct()
    {
        $this->publications = new ArrayCollection();
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
     * Set file
     *
     * @param string $file
     *
     * @return GoodDesign
     */
    public function setFile($file)
    {
        $this->file = $file;

        return $this;
    }

    /**
     * Get file
     *
     * @return string
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return GoodDesign
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
    public function getGood()
    {
        return $this->good;
    }

    /**
     * @param mixed $good
     */
    public function setGood($good)
    {
        $this->good = $good;
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



}

