<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 * @ORM\Table(name="user")
 * @ORM\HasLifecycleCallbacks()
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="lastName", type="string")
     * @Assert\NotBlank(message="Данное поле обязательно для заполнения")
     */
    protected $lastName;

    /**
     * @var string
     *
     * @ORM\Column(name="firstName", type="string")
     * @Assert\NotBlank(message="Данное поле обязательно для заполнения")
     */
    protected $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="surName", type="string", nullable=true)
     */
    protected $surName;


    /**
     * @var string
     *
     * @ORM\Column(name="post", type="string")
     * @Assert\NotBlank(message="Данное поле обязательно для заполнения")
     */
    protected $post;


    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Company", mappedBy="user")
     */
    private $companies;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Mediaplan", mappedBy="user")
     */
    private $mediaplans;


    public function __construct()
    {
        parent::__construct();
        $this->companies = new ArrayCollection();
        $this->mediaplans = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }


    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string
     */
    public function getSurName()
    {
        return $this->surName;
    }

    public function getFullName(){
        return $this->lastName.' '.$this->firstName.' '.$this->surName;
    }

    /**
     * @param string $surName
     */
    public function setSurName($surName)
    {
        $this->surName = $surName;
    }

    public function isAdmin(){
        foreach ($this->getRoles() as $role){
            if ($role == 'ROLE_ADMIN'){
                return true;
            }
        }
        return false;
    }

    /**
     * @return string
     */
    public function getPost()
    {
        return $this->post;
    }

    /**
     * @param string $post
     */
    public function setPost($post)
    {
        $this->post = $post;
    }

    /**
     * @return mixed
     */
    public function getCompanies()
    {
        return $this->companies;
    }

    /**
     * @param mixed $companies
     */
    public function setCompanies($companies)
    {
        $this->companies = $companies;
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

    public function setRoles(array $roles)
    {
        $this->roles = $roles;
    }

}
