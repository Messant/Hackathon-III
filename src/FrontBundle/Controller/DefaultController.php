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
        return $this->render('FrontBundle:Default:homepage.html.twig');
    }

    /**
     * @Route("/joueur", name="joueur")
     */
    public function joueurAction()
    {
        return $this->render('FrontBundle:Default:joueur.html.twig');
    }

    /**
     * @Route("/plateforme", name="plateforme")
     */
    public function plateformeAction()
    {
        return $this->render('FrontBundle:Default:plateforme.html.twig');
    }

    /**
     * @Route("/classement", name="classement")
     */
    public function classementAction()
    {
        return $this->render('FrontBundle:Default:classement.html.twig');
    }

    /**
     * @Route("/joueur_envoi", name="joueur_Envoi")
     */
    public function joueurEnvoiAction()
    {
        return $this->render('FrontBundle:Default:joueur_envoi_photo.html.twig');
    }

    /**
     * @Route("/meneur_validation", name="meneur_validation")
     */
    public function meneurValidationAction()
    {
        return $this->render('FrontBundle:Default:meneur_validation.html.twig');
    }

    /**
     * @Route("/status", name="status")
     */
    public function statusAction()
    {
        return $this->render('FrontBundle:Default:status.html.twig');
    }
}
