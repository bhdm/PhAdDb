<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Company
 *
 * @ORM\Table(name="companies")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CompanyRepository")
 */
class Company
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
     * @Assert\NotBlank(message="Название компании обязательно для заполнения")
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="requisites", type="text", nullable=true)
     */
    private $requisites;

    /**
     * @var string
     *
     * @ORM\Column(name="contact", type="string", nullable=true)
     */
    private $contact;

    /**
     * @var string
     *
     * @ORM\Column(name="contactPerson", type="string", nullable=true)
     */
    private $contactPerson;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Company", mappedBy="company")
     */
    private $goods;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Mediaplan", mappedBy="company")
     */
    private $mediaplans;


    public function __toString()
    {
        return $this->getTitle();
    }

    public function __construct()
    {
        $this->goods = new ArrayCollection();
        $this->mediaplans = new ArrayCollection();
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
     * @return Company
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

    /**
     * @return string
     */
    public function getRequisites()
    {
        return $this->requisites;
    }

    /**
     * @param string $requisites
     */
    public function setRequisites($requisites)
    {
        $this->requisites = $requisites;
    }

    /**
     * @return string
     */
    public function getContact()
    {
        return $this->contact;
    }

    /**
     * @param string $contact
     */
    public function setContact($contact)
    {
        $this->contact = $contact;
    }

    /**
     * @return string
     */
    public function getContactPerson()
    {
        return $this->contactPerson;
    }

    /**
     * @param string $contactPerson
     */
    public function setContactPerson($contactPerson)
    {
        $this->contactPerson = $contactPerson;
    }


}

