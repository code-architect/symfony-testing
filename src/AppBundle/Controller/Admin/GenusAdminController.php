<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Genus;
use AppBundle\Form\GenusFormType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/admin")
 */
class GenusAdminController extends Controller
{



    /**
     * @Route("/genus", name="admin_genus_list")
     */
    public function indexAction()
    {
        $genuses = $this->getDoctrine()
            ->getRepository('AppBundle:Genus')
            ->findAll();

        return $this->render('admin/genus/list.html.twig', array(
            'genuses' => $genuses
        ));
    }



    /**
     * @Route("/genus/new", name="admin_genus_new")
     */
    public function newAction(Request $request)
    {
        $form = $this->createForm(GenusFormType::class);

        // only happens for post request
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $genus = $form->getData();

            // Get the entity manager
            $em = $this->getDoctrine()->getManager();
            $em->persist($genus);
            $em->flush();

            // Flash message
            $this->addFlash('success', 'Genus Created - Congrats!!!');

            // redirecting
            return $this->redirectToRoute('admin_genus_list');

        }

        return $this->render('admin/genus/new.html.twig', [
            'genusForm' => $form->createView()
        ]);
    }


    /**
     * @Route("/genus/{id}/edit", name="admin_genus_edit")
     */
    public function editAction(Request $request, Genus $genus)
    {
        $form = $this->createForm(GenusFormType::class, $genus);

        // only happens for post request
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $genus = $form->getData();

            // Get the entity manager
            $em = $this->getDoctrine()->getManager();
            $em->persist($genus);
            $em->flush();

            // Flash message
            $this->addFlash('success', 'Genus Updated - Congrats!!!');

            // redirecting
            return $this->redirectToRoute('admin_genus_list');

        }

        return $this->render('admin/genus/edit.html.twig', [
            'genusForm' => $form->createView()
        ]);
    }


}