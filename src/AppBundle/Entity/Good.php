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
     * @Assert\NotBlank(message="Название рекламного модуля обязательно для заполнения")
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

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Price", inversedBy="goods")
     */
    private $price;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Mediaplan", inversedBy="goods")
     */
    private $mediaplan;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(message="месяц обязательно для заполнения")
     */
    private $month;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Regex("/^[0-9]+$/")
     */
    private $sale;

    public function __construct()
    {
        $this->sale = 0;
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

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param mixed $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * @return mixed
     */
    public function getMediaplan()
    {
        return $this->mediaplan;
    }

    /**
     * @param mixed $mediaplan
     */
    public function setMediaplan($mediaplan)
    {
        $this->mediaplan = $mediaplan;
    }

    /**
     * @return mixed
     */
    public function getMonth()
    {
        return $this->month;
    }

    /**
     * @param mixed $month
     */
    public function setMonth($month)
    {
        $this->month = $month;
    }

    public function monthStr(){
        switch ($this->month){
            case 1: return 'Январь'; break;
            case 2: return 'Февраль'; break;
            case 3: return 'март'; break;
            case 4: return 'Апрель'; break;
            case 5: return 'Май'; break;
            case 6: return 'Июнь'; break;
            case 7: return 'Июль'; break;
            case 8: return 'Август'; break;
            case 9: return 'Сентябрь'; break;
            case 10: return 'Октябрь'; break;
            case 11: return 'Ноябрь'; break;
            case 12: return 'Декабрь'; break;
        }
    }

    /**
     * @return mixed
     */
    public function getSale()
    {
        return $this->sale;
    }

    /**
     * @param mixed $sale
     */
    public function setSale($sale)
    {
        $this->sale = $sale;
    }

}

