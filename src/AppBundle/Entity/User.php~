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
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Etat")
     */
    protected $etats;

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

    /**
     * @ORM\OneToMany(targetEntity="Photo", mappedBy="user")
     */
    protected $photos;

    /**
     * @return mixed
     */
    public function getPhotos()
    {
        return $this->photos;
    }

    /**
     * @param mixed $photos
     */
    public function setPhotos($photos)
    {
        $this->photos = $photos;
    }



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

    /**
     * Add photos
     *
     * @param \AppBundle\Entity\Photo $photos
     * @return User
     */
    public function addPhoto(\AppBundle\Entity\Photo $photos)
    {
        $this->photos[] = $photos;

        return $this;
    }

    /**
     * Remove photos
     *
     * @param \AppBundle\Entity\Photo $photos
     */
    public function removePhoto(\AppBundle\Entity\Photo $photos)
    {
        $this->photos->removeElement($photos);
    }

    /**
     * @param mixed $etats
     */
    public function setEtats($etats)
    {
        $this->etats = $etats;
    }

    /**
     * @return mixed
     */
    public function getEtats()
    {
        return $this->etats;
    }

}
