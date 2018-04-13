<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
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
     * @ORM\OneToMany(targetEntity="App\Entity\Currency", mappedBy="createdBy")
     */
    private $currencies;

    public function __construct()
    {
        parent::__construct();
        $this->currencies = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getCurrencies()
    {
        return $this->currencies;
    }

    public function addCurrency(Currency $currency)
    {
        if ($this->currencies->contains($currency)) {
            return;
        }

        $this->currencies[] = $currency;
        // set the *owning* side!
        $currency->setCreatedBy($this);
    }

    public function removeCurrency(Currency $currency)
    {
        $this->currencies->removeElement($currency);
        // set the owning side to null
        $currency->setCreatedBy(null);
    }
}