<?php

namespace App\Controller\Target;


use App\Entity\Target;
use App\Repository\TargetRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

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
    public function updateAction(Request $request,target $target,FormFactoryInterface $targetForm)
    {
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
            'admin/target/view.html.twig',
            array(
                'form' => $form->createView(),
                'target' => $target)
        );
    }

    /**
     * @Route("/admin/targets/delete/{id}", name="target_delete")
     */
    public function deleteAction(target $target,Environment $twig, targetRepository $targetsRep)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($target);
        $em->flush();

        $targets = $targetsRep->findAll();


        return new Response($twig->render('admin/target/list.html.twig',[
            'targets' => $targets
        ]));
    }

}

