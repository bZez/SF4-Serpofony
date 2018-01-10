<?php

// src/Controller/User/RegistrationController.php
namespace App\Controller\Search;

use App\Form\SearchType;
use App\Entity\Search;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
class RegistrationController extends Controller
{
    /**
     * @Route("/searches/new", name="search_form")
     */
    public function registerAction(Request $request)
    {
        // 1) build the form
        $search = new Search();
        $form = $this->createForm(SearchType::class, $search);

        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            // 4) save theSearch!
            $em = $this->getDoctrine()->getManager();
            $em->persist($search);
            $em->flush();

            // ... do any other work - like sending them an email, etc
            // maybe set a "flash" success message for the search

            return $this->redirectToRoute('searches');
        }

        return $this->render(
            'admin/search/new.html.twig',
            array('form' => $form->createView())
        );
    }
}