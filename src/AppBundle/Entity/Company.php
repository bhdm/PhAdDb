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
     * @ORM\Column(name="contact_phone", type="string", nullable=true)
     */
    private $contactPhone;

    /**
     * @var string
     *
     * @ORM\Column(name="contact_email", type="string", nullable=true)
     */
    private $contactEmail;

    /**
     * @var string
     *
     * @ORM\Column(name="contact_person", type="string", nullable=true)
     */
    private $contactPerson;


    /**
     * @var string
     *
     * @ORM\Column(name="contact_post", type="string", nullable=true)
     */
    private $contactPost;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Company", mappedBy="company")
     */
    private $goods;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Mediaplan", mappedBy="company")
     */
    private $mediaplans;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="companies")
     */
    private $user;


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

    /**
     * @return string
     */
    public function getContactPhone()
    {
        return $this->contactPhone;
    }

    /**
     * @param string $contactPhone
     */
    public function setContactPhone($contactPhone)
    {
        $this->contactPhone = $contactPhone;
    }

    /**
     * @return string
     */
    public function getContactEmail()
    {
        return $this->contactEmail;
    }

    /**
     * @param string $contactEmail
     */
    public function setContactEmail($contactEmail)
    {
        $this->contactEmail = $contactEmail;
    }

    /**
     * @return mixed
     */
    public function getContactPost()
    {
        return $this->contactPost;
    }

    /**
     * @param mixed $contactPost
     */
    public function setContactPost($contactPost)
    {
        $this->contactPost = $contactPost;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }


}

