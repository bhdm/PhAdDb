<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
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
     */
    protected $lastName;

    /**
     * @var string
     *
     * @ORM\Column(name="firstName", type="string")
     */
    protected $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="surName", type="string", nullable=true)
     */
    protected $surName;



    public function __construct()
    {
        parent::__construct();
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
}
