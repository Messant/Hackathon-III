<?php

namespace BackBundle\Controller;

use BackBundle\Entity\Etat;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Etat controller.
 *
 * @Route("etat")
 */
class EtatController extends Controller
{
    /**
     * Lists all etat entities.
     *
     * @Route("/", name="etat_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $etats = $em->getRepository('BackBundle:Etat')->findAll();

        return $this->render('etat/index.html.twig', array(
            'etats' => $etats,
            'couleur_etat' => $this->getStatus_couleur(),
        ));
    }

    /**
     * Creates a new etat entity.
     *
     * @Route("/new", name="etat_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $etat = new Etat();
        $form = $this->createForm('BackBundle\Form\EtatType', $etat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($etat);
            $em->flush($etat);

            return $this->redirectToRoute('etat_show', array('id' => $etat->getId()));
        }

        return $this->render('etat/new.html.twig', array(
            'etat' => $etat,
            'form' => $form->createView(),
            'couleur_etat' => $this->getStatus_couleur(),
        ));
    }

    /**
     * Finds and displays a etat entity.
     *
     * @Route("/{id}", name="etat_show")
     * @Method("GET")
     */
    public function showAction(Etat $etat)
    {
        $deleteForm = $this->createDeleteForm($etat);

        return $this->render('etat/show.html.twig', array(
            'etat' => $etat,
            'delete_form' => $deleteForm->createView(),
            'couleur_etat' => $this->getStatus_couleur(),
        ));
    }

    /**
     * Displays a form to edit an existing etat entity.
     *
     * @Route("/{id}/edit", name="etat_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Etat $etat)
    {
        $deleteForm = $this->createDeleteForm($etat);
        $editForm = $this->createForm('BackBundle\Form\EtatType', $etat);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('etat_edit', array('id' => $etat->getId()));
        }

        return $this->render('etat/edit.html.twig', array(
            'etat' => $etat,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'couleur_etat' => $this->getStatus_couleur(),
        ));
    }

    /**
     * Deletes a etat entity.
     *
     * @Route("/{id}", name="etat_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Etat $etat)
    {
        $form = $this->createDeleteForm($etat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($etat);
            $em->flush($etat);
        }

        return $this->redirectToRoute('etat_index');
    }

    /**
     * Creates a form to delete a etat entity.
     *
     * @param Etat $etat The etat entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Etat $etat)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('etat_delete', array('id' => $etat->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
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
     * @Route("/photo/{id}/", name="joueur_envoi_photo")
     */
    public function showPhotoPlayerAction()
    {
        $photos = $this->getDoctrine()
            ->getRepository('BackBundle:Photo')
            ->findBy();


        return $this->render('FrontBundle:Default:joueur_envoi_photo.html.twig', array('photo'=>$photos));
    }
}
