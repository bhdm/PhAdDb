<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Good
 *
 * @ORM\Table(name="goods")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\GoodRepository")
 */
class Good
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
     * @Assert\NotBlank(message="Название товара обязательно для заполнения")
     */
    private $title;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Company", inversedBy="goods")
     */
    private $company;

    /**
     * @var Good
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\GoodDesign", mappedBy="good")
     */
    private $designs;

    /**
     * @var GoodPublication
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\GoodPublication", mappedBy="good")
     */
    private $publications;

    public function __construct()
    {
        $this->designs = new ArrayCollection();
        $this->publications = new ArrayCollection();
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
     * @return Good
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
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * @param mixed $company
     */
    public function setCompany($company)
    {
        $this->company = $company;
    }

    /**
     * @return Good
     */
    public function getDesigns()
    {
        return $this->designs;
    }

    /**
     * @param Good $designs
     */
    public function setDesigns($designs)
    {
        $this->designs = $designs;
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

