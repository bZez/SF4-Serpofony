<?php

// src/Controller/User/RegistrationController.php
namespace App\Controller\Target;

use App\Form\TargetType;
use App\Entity\Target;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
class RegistrationController extends Controller
{
    /**
     * @Route("/targets/new", name="target_form")
     */
    public function registerAction(Request $request)
    {
        // 1) build the form
        $target = new Target();
        $form = $this->createForm(TargetType::class, $target);

        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            // 4) save theTarget!
            $em = $this->getDoctrine()->getManager();
            $em->persist($target);
            $em->flush();

            // ... do any other work - like sending them an email, etc
            // maybe set a "flash" success message for the target

            return $this->redirectToRoute('targets');
        }

        return $this->render(
            'admin/target/new.html.twig',
            array('form' => $form->createView())
        );
    }
}