<?php

namespace App\Controller\Target;


use App\Entity\Group;
use App\Entity\Target;
use App\Repository\GroupRepository;
use App\Repository\TargetRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Form\TargetType;

class TargetController extends Controller
{
    /**
     * @Route("/admin/targets", name="targets")
     */
    public function listAction(Environment $twig, TargetRepository $targetsRep)
    {
        $targets = $targetsRep->findAll();


        return new Response($twig->render('admin/target/list.html.twig',[
            'targets' => $targets
        ]));
    }

    /**
     * @Route("/admin/targets/{id}", name="target_show")
     */
    public function showAction(Environment $twig,Target $target)
    {
        if (!$target) {
            throw $this->createNotFoundException(
                'No target found for id '.$target
            );
        }
        return new Response($twig->render('admin/target/view.html.twig', ['target' => $target]));
    }

    /**
     * @Route("/admin/targets/edit/{id}", name="target_edit")
     */
    public function updateAction(Request $request,Target $target,FormFactoryInterface $targetForm,GroupRepository $groupRep)
    {
        $groups = $groupRep->findAll();
        $doctrine = $this->getDoctrine()->getManager();
        $form = $targetForm->createBuilder(targetType::class, $target)->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $doctrine->persist($target);
            $doctrine->flush();
        }

        if (!$target) {
            throw $this->createNotFoundException(
                'No target found for id '.$target
            );
        }

        return $this->render(
            'admin/target/new.html.twig',
            array(
                'form' => $form->createView(),
                'groups' => $groups,
                'target' => $target)
        );
    }

    /**
     * @Route("/admin/targets/delete/{id}", name="target_delete")
     */
    public function deleteAction(Target $target,Environment $twig, TargetRepository $targetsRep)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($target);
        $em->flush();

        $targets = $targetsRep->findAll();


        return new Response($twig->render('admin/target/list.html.twig',[
            'targets' => $targets
        ]));
    }

    /**
     * @Route("/targets/new", name="target_form")
     */
    public function addAction(Request $request, GroupRepository $groupRep)
    {
        $groups = $groupRep->findAll();
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
            array(
                'groups' => $groups,
                'form' => $form->createView())
        );
    }

}

