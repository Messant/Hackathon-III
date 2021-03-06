<?php

namespace BackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use BackBundle\Entity\User;
use BackBundle\Form\UserType;
use FOS\UserBundle\Form\Type\UsernameFormType;


class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        return $this->render('BackBundle:Default:index.html.twig');
    }

    /**
     * @Route("/go", name="go")
     */
    public function statusAction()
    {
        return $this->render('FrontBundle:Default:admin_debut.html.twig', array(
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
     * @Route("/gogo", name="gogo")
     */
    public function getGo_etat()
    {
        $em = $this->getDoctrine()->getManager();
        $en_attente =$em->getRepository('FrontBundle:EtatJeux')->find(1);
        $en_attente->setEtat(1);
        $em = $this->getDoctrine()->getManager();
        $em->persist($en_attente);
        $em->flush();
        $joueurs =$em->getRepository('BackBundle:User')->findAll();
        $elu=$joueurs[array_rand($joueurs)];
        $elu->setMeneur(1);
        $em = $this->getDoctrine()->getManager();
        $em->persist($elu);
        $em->flush();

        $user = $this->get('security.token_storage')->getToken()->getUser();
        $test=$user->getRoles();
        $etat_jeu =$em->getRepository('FrontBundle:EtatJeux')->findAll();

        if ($test[0] == 'ROLE_ADMIN' && $etat_jeu[0]->getEtat()==2  ){
            $role='go';
        }else{
            $role="joueur";
        }
        return $this->render('FrontBundle:Default:index.html.twig', array(
            'couleur_etat' => $this->getStatus_couleur(),
            'role' => $role,
        ));
    }
}
