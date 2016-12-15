<?php
/**
 * Created by PhpStorm.
 * User: m21
 * Date: 25/11/16
 * Time: 12:01
 */

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
     * @ORM\Column(name="meneur", type="boolean")
     */
    private $meneur;

    /**
     * @var string
     *
     * @ORM\Column(name="classement", type="integer")
     */
    private $classement;



    /**
     * @return string
     */
    public function getMeneur()
    {
        return $this->meneur;
    }

    /**
     * @param string $meneur
     */
    public function setMeneur($meneur)
    {
        $this->meneur = $meneur;
    }

    /**
     * @return string
     */
    public function getClassement()
    {
        return $this->classement;
    }

    /**
     * @param string $classement
     */
    public function setClassement($classement)
    {
        $this->classement = $classement;
    }

    /**
     * @param int $etat
     */
    public function setEtat($etat)
    {
        $this->etats = $etat;
    }

    /**
     * @return int
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
