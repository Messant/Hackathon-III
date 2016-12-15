<?php

namespace BackBundle\Controller;

use BackBundle\Entity\Photo;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

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
            $logo = $photo->getPhoto();

            // Generate a unique name for the file before saving it
            $photoName = md5(uniqid()).'.'.$photo->guessExtension();

            // Move the file to the directory where brochures are stored
            $logo->move(
                $this->getParameter('upload_directory'),
                $photoName
            );
            // Update the 'brochure' property to store the PDF file name
            // instead of its contents
            $photo->setPhoto($photoName);

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
        if (is_file ($photo->getPhoto())) {
            $old_photo = new Photo($this->getParameter('upload_directory') . '/' . $photo->getPhoto());
        } else {
            $photo->setPhoto('');
        }

        $deleteForm = $this->createDeleteForm($photo);
        $editForm = $this->createForm('BackBundle\Form\PartenaireType', $photo);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            // Update the 'brochure' property to store the PDF file name
            // instead of its contents
            if (!$photo->getPhoto())
            {
                $photo->setPhoto($old_photo);
            } else
            {
                $Photo = $photo->getPhoto();

                // Generate a unique name for the file before saving it
                $photoName = md5(uniqid()).'.'.$photo->guessExtension();

                // Move the file to the directory where brochures are stored
                $photo->move(
                    $this->getParameter('upload_directory'),
                    $photoName
                );
                $photo->setLogo($photoName);

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
