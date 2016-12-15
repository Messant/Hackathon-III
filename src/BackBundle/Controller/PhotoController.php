<?php

namespace BackBundle\Controller;

use BackBundle\Entity\Photo;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\Url;

/**
 * Photo controller.
 *
 * @Route("photo")
 */
class PhotoController extends Controller
{
    /**
     * Lists all photo entities.
     *
     * @Route("/", name="photo_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $photos = $em->getRepository('BackBundle:Photo')->findAll();

        return $this->render('photo/index.html.twig', array(
            'photos' => $photos,
            'couleur_etat' => $this->getStatus_couleur(),
        ));
    }

    /**
     * Creates a new photo entity.
     *
     * @Route("/new", name="photo_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $photo = new Photo();
        $form = $this->createForm('BackBundle\Form\PhotoType', $photo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $url = $photo->getUrl();

            // Generate a unique name for the file before saving it
            $urlName = md5(uniqid()).'.'.$url->guessExtension();

            // Move the file to the directory where brochures are stored
            $url->move(
                $this->getParameter('upload_directory'),
                $urlName
            );
            // Update the 'brochure' property to store the PDF file name
            // instead of its contents
            $photo->setUrl($urlName);

            $em = $this->getDoctrine()->getManager();
            $em->persist($photo);
            $em->flush($photo);

            return $this->redirectToRoute('photo_show', array('id' => $photo->getId()));
        }

        return $this->render('photo/new.html.twig', array(
            'photo' => $photo,
            'form' => $form->createView(),
            'couleur_etat' => $this->getStatus_couleur(),
        ));
    }

    /**
     * Finds and displays a photo entity.
     *
     * @Route("/{id}", name="photo_show")
     * @Method("GET")
     */
    public function showAction(Photo $photo)
    {
        $deleteForm = $this->createDeleteForm($photo);

        return $this->render('photo/show.html.twig', array(
            'photo' => $photo,
            'delete_form' => $deleteForm->createView(),
            'couleur_etat' => $this->getStatus_couleur(),
        ));
    }

    /**
     * Displays a form to edit an existing photo entity.
     *
     * @Route("/{id}/edit", name="photo_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Photo $photo)
    {
        if (is_file ($photo->getUrl())) {
            $old_photo = new Url($this->getParameter('upload_directory') . '/' . $photo->getUrl());
        } else {
            $photo->setUrl('');
        }

        $deleteForm = $this->createDeleteForm($photo);
        $editForm = $this->createForm('BackBundle\Form\PhotoType', $photo);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            // Update the 'brochure' property to store the PDF file name
            // instead of its contents
            if (!$photo->getUrl())
            {
                $photo->setUrl($old_photo);
            } else
            {
                $url = $photo->getUrl();

                // Generate a unique name for the file before saving it
                $urlName = md5(uniqid()).'.'.$url->guessExtension();

                // Move the file to the directory where brochures are stored
                $url->move(
                    $this->getParameter('upload_directory'),
                    $urlName
                );
                $photo->setUrl($urlName);

            }
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('photo_edit', array('id' => $photo->getId()));
        }

        return $this->render('photo/edit.html.twig', array(
            'photo' => $photo,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'couleur_etat' => $this->getStatus_couleur(),
        ));
    }

    /**
     * Deletes a photo entity.
     *
     * @Route("/{id}", name="photo_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Photo $photo)
    {
        $form = $this->createDeleteForm($photo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($photo);
            $em->flush($photo);
        }

        return $this->redirectToRoute('photo_index');
    }

    /**
     * Creates a form to delete a photo entity.
     *
     * @param Photo $photo The photo entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Photo $photo)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('photo_delete', array('id' => $photo->getId())))
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
}
