<?php

namespace FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use FrontBundle\Entity\Photo;

class JoueurController extends Controller
{
    /**
     * @Route("/photo/{id}/", name="joueur_envoi_photo")
     */
    public function showPhotoPlayerAction()
    {
        $photos = $this->getDoctrine()
            ->getRepository('BackBundle:Photo')
            ->findBy();


        return $this->render('FrontBundle:Default:joueur_envoi_photo.html.twig', array('photo'=>$photos, 'url'=>basename($Photo->getPhoto()),));
    }
}
