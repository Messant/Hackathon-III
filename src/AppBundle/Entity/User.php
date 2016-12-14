<?php
// src/AppBundle/Entity/User.php

namespace AppBundle\Entity;

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
     * @ORM\ManyToOne(targetEntity="Etat")
     */
    protected $id;

    /**
     *
     * @ORM\Column(type="integer")
     *
     */
    protected $classement;

    /**
     *
     * @ORM\Column(type="boolean")
     *
     */
    protected $meneur;

    public function __construct()
    {
        parent::__construct();
        // your own logic
    }

    /**
     * Set classement
     *
     * @param integer $classement
     * @return User
     */
    public function setClassement($classement)
    {
        $this->classement = $classement;

        return $this;
    }

    /**
     * Get classement
     *
     * @return integer 
     */
    public function getClassement()
    {
        return $this->classement;
    }

    /**
     * Set meneur
     *
     * @param boolean $meneur
     * @return User
     */
    public function setMeneur($meneur)
    {
        $this->meneur = $meneur;

        return $this;
    }

    /**
     * Get meneur
     *
     * @return boolean 
     */
    public function getMeneur()
    {
        return $this->meneur;
    }
}
