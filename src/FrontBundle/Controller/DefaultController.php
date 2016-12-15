<?php

namespace FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        return $this->render('FrontBundle:Default:index.html.twig');
    }

    /**
     * @Route("/homepage", name="homepage")
     */
    public function homepageAction()
    {
        return $this->render('FrontBundle:Default:homepage.html.twig', array(
            'couleur_etat' => $this->getStatus_couleur(),
        ));
    }

    /**
     * @Route("/joueur", name="joueur")
     */
    public function joueurAction()
    {
        return $this->render('FrontBundle:Default:joueur.html.twig', array(
            'couleur_etat' => $this->getStatus_couleur(),
        ));
    }

    /**
     * @Route("/plateforme", name="plateforme")
     */
    public function plateformeAction()
    {
        return $this->render('FrontBundle:Default:plateforme.html.twig', array(
            'couleur_etat' => $this->getStatus_couleur(),
        ));
    }

    /**
     * @Route("/classement", name="classement")
     */
    public function classementAction()
    {
        return $this->render('FrontBundle:Default:classement.html.twig', array(
            'couleur_etat' => $this->getStatus_couleur(),
        ));
    }

    /**
     * @Route("/joueur_envoi", name="joueur_Envoi")
     */
    public function joueurEnvoiAction()
    {
        return $this->render('FrontBundle:Default:joueur_envoi_photo.html.twig', array(
            'couleur_etat' => $this->getStatus_couleur(),
        ));
    }

    /**
     * @Route("/meneur_validation", name="meneur_validation")
     */
    public function meneurValidationAction()
    {
        return $this->render('FrontBundle:Default:meneur_validation.html.twig', array(
            'couleur_etat' => $this->getStatus_couleur(),
        ));
    }

    /**
     * @Route("/status", name="status")
     */
    public function statusAction()
    {
        return $this->render('FrontBundle:Default:status.html.twig', array(
            'couleur_etat' => $this->getStatus_couleur(),
        ));
    }

    /**
     * @Route("/nav", name="nav")
     */
    public function navAction()
    {

        return $this->render('FrontBundle:Default:navbar.html.twig', array(
            'couleur_etat' => $this->getStatus_couleur(),
        ));
    }

    private function getStatus_couleur(){
        $em = $this->getDoctrine()->getManager();
        $statut = 2 ;
        $etats = $em->getRepository('BackBundle:Etat')->findAll();
        $couleur =($etats [$statut]);
        $couleur_etat =($couleur-> getCouleur());
        return $couleur_etat;
    }

}
