<?php
// src/AppBundle/Entity/User.php

namespace BackBundle\Entity;

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

    public function __construct()
    {
        parent::__construct();
        // your own logic
    }

    /**
    * @var string
    *
    * @ORM\OneToMany(targetEntity="Photo", mappedBy="user")
    */
    private $photos;

    /**
     * @var int
     *
     * @ORM\ManyToOne(targetEntity="Etat", inversedBy="users")
     */
    private $etat;

    /**
     * @var string
     *
     * @ORM\Column(name="meneur", type="boolean", nullable=true)
     */
    private $meneur;

    /**
     * @var int
     *
     * @ORM\Column(name="classement", type="integer", nullable=true)
     */
    private $classement;

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
     * Set etat
     *
     * @param \BackBundle\Entity\Etat $etat
     * @return User
     */
    public function setEtat(\BackBundle\Entity\Etat $etat = null)
    {
        $this->etat = $etat;

        return $this;
    }

    /**
     * Get etat
     *
     * @return \BackBundle\Entity\Etat 
     */
    public function getEtat()
    {
        return $this->etat;
    }

    /**
     * Add photos
     *
     * @param \BackBundle\Entity\Photo $photos
     * @return User
     */
    public function addPhoto(\BackBundle\Entity\Photo $photos)
    {
        $this->photos[] = $photos;

        return $this;
    }

    /**
     * Remove photos
     *
     * @param \BackBundle\Entity\Photo $photos
     */
    public function removePhoto(\BackBundle\Entity\Photo $photos)
    {
        $this->photos->removeElement($photos);
    }

    /**
     * Get photos
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPhotos()
    {
        return $this->photos;
    }
}
