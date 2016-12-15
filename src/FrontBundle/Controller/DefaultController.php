<?php

namespace FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use FrontBundle\Entity\EtatJeux;
use FOS\UserBundle\Model\UserInterface;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->render('FrontBundle:Default:homepage.html.twig', array(
            'couleur_etat' => $this->getStatus_couleur()));
        }
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();
        $joueurs =$em->getRepository('BackBundle:User')->findAll();
        $log=$joueurs[($user->getId())];
        $test=$user->getRoles();
        $etat_jeu =$em->getRepository('FrontBundle:EtatJeux')->findAll();
        $users =$em->getRepository('BackBundle:User')->findAll();
        $user_meneur=$users[($user->getId()-1)];
        $user_meneur_fini= $user_meneur->getMeneur();
       // var_dump($user_meneur_fini);

        if ($test[0] == 'ROLE_ADMIN' && $etat_jeu[0]->getEtat()==2  ) {
            $role = 'gogo';
        }elseif ($user_meneur_fini == 1){
            $role = 'meneur_validation';
        }else{
            $role="joueur";
        }

        return $this->render('FrontBundle:Default:index.html.twig', array(
            'couleur_etat' => $this->getStatus_couleur(),
            'log' => $log,
            'role' => $role,
        ));
    }

    /**
     * @Route("/homepage", name="homepage")
     */
    public function homepageAction()
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();
        $joueurs =$em->getRepository('BackBundle:User')->findAll();
        $log=$joueurs[($user->getId())];
        var_dump($user->getId());
        return $this->render('FrontBundle:Default:homepage.html.twig', array(
            'couleur_etat' => $this->getStatus_couleur(),
            'log' => $log,
        ));
    }

    /**
     * @Route("/joueur", name="joueur")
     */
    public function joueurAction()
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY'))

        { throw $this->createAccessDeniedException(); }
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $username = ($user->getUsername());
        $email = ($user->getEmail());
        $classement = ($user->getClassement());


        return $this->render('FrontBundle:Default:joueur.html.twig', array(
            'couleur_etat' => $this->getStatus_couleur(),
            'username' => $username,
            'email' => $email,
            'classement' => $classement,
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

    private function getStatus_couleur()
    {
        $em = $this->getDoctrine()->getManager();
        $etats = $em->getRepository('BackBundle:Etat')->findAll();
        $etatsactu = $em->getRepository('FrontBundle:EtatJeux')->findAll();
        $statut = $etatsactu[0]->getEtat() ;
        $couleur =($etats [$statut]);
        $couleur_etat =($couleur-> getCouleur());
        return $couleur_etat;
    }

    /**
     * @Route("/changetat", name="changetat")
     */
    public function getStatus_etat()
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
                throw $this->createAccessDeniedException();
        }
        $user = $this->get('security.token_storage')->getToken()->getUser();
        //var_dump($user->getId());


        $em = $this->getDoctrine()->getManager();
        $en_attente =$em->getRepository('FrontBundle:EtatJeux')->find(1);
        $en_attente->setEtat(1);
        $em = $this->getDoctrine()->getManager();
        $em->persist($en_attente);
        $em->flush();

        $joueurs =$em->getRepository('BackBundle:User')->findAll();
        $elu=$joueurs[($user->getId())-1];
        $elu->setMeneur(0);
        $em = $this->getDoctrine()->getManager();
        $em->persist($elu);
        $em->flush();

        $joueur_gagnant = 4;
        $nv_elu=$joueurs[$joueur_gagnant -1];
        $nv_elu->setMeneur(1);
        $nvclassement = $nv_elu->getClassement()+1;
        $nv_elu->setClassement($nvclassement);
        $em = $this->getDoctrine()->getManager();
        $em->persist($elu);
        $em->flush();



        return $this->render('FrontBundle:Default:joueur.html.twig', array(
            'couleur_etat' => $this->getStatus_couleur(),
        ));
    }

}
