<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Mediaplan
 *
 * @ORM\Table(name="mediaplan")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MediaplanRepository")
 */
class Mediaplan
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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Magazine", inversedBy="mediaplans")
     */
    private $magazine;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $idn;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Regex("/^[0-9]+$/")
     */
    private $year;

    /**
     * @ORM\Column(type="array")
     */
    private $months;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Regex("/^[0-9]+$/")
     */
    private $price;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Regex("/^[0-9]+$/")
     */
    private $budget;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Regex("/^[0-9]+$/")
     */
    private $sale;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Regex("/^[0-9]+$/")
     */
    private $commission;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Regex("/^[0-9]+$/")
     */
    private $interalBudget;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Regex("/^[0-9]+$/")
     */
    private $interalSale;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $contractNumber;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Company", inversedBy="mediaplans")
     */
    private $company;

    public function __toString()
    {
        return $this->getMagazine()->getTitle().'';
    }

    public function __construct()
    {
        $this->months = array(
            '1' => 0,
            '2' => 0,
            '3' => 0,
            '4' => 0,
            '5' => 0,
            '6' => 0,
            '7' => 0,
            '8' => 0,
            '9' => 0,
            '10' => 0,
            '11' => 0,
            '12' => 0,
        );
    }

    /**
     * @return mixed
     */
    public function getMagazine()
    {
        return $this->magazine;
    }

    /**
     * @param mixed $magazine
     */
    public function setMagazine($magazine)
    {
        $this->magazine = $magazine;
    }

    /**
     * @return mixed
     */
    public function getIdn()
    {
        return $this->idn;
    }

    /**
     * @param mixed $idn
     */
    public function setIdn($idn)
    {
        $this->idn = $idn;
    }

    /**
     * @return mixed
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * @param mixed $year
     */
    public function setYear($year)
    {
        $this->year = $year;
    }

    /**
     * @return mixed
     */
    public function getMonths()
    {
        return $this->months;
    }

    /**
     * @param mixed $months
     */
    public function setMonths($months)
    {
        $this->months = $months;
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
    public function getBudget()
    {
        return $this->budget;
    }

    /**
     * @param mixed $budget
     */
    public function setBudget($budget)
    {
        $this->budget = $budget;
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

    /**
     * @return mixed
     */
    public function getCommission()
    {
        return $this->commission;
    }

    /**
     * @param mixed $commission
     */
    public function setCommission($commission)
    {
        $this->commission = $commission;
    }

    /**
     * @return mixed
     */
    public function getInteralBudget()
    {
        return $this->interalBudget;
    }

    /**
     * @param mixed $interalBudget
     */
    public function setInteralBudget($interalBudget)
    {
        $this->interalBudget = $interalBudget;
    }

    /**
     * @return mixed
     */
    public function getInteralSale()
    {
        return $this->interalSale;
    }

    /**
     * @param mixed $interalSale
     */
    public function setInteralSale($interalSale)
    {
        $this->interalSale = $interalSale;
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
     * @return mixed
     */
    public function getContractNumber()
    {
        return $this->contractNumber;
    }

    /**
     * @param mixed $contractNumber
     */
    public function setContractNumber($contractNumber)
    {
        $this->contractNumber = $contractNumber;
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

    public function getCount(){
        $sum = 0;
        foreach ($this->months as $m){
            $sum += $m;
        }
        return $sum;
    }

}

