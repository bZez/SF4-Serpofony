<?php

namespace App\Controller\Search;


use App\Entity\Search;
use App\Form\SearchType;
use App\Repository\GroupRepository;
use App\Repository\RankRepository;
use App\Repository\SearchRepository;
use App\Repository\TargetRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SearchController extends Controller
{
    /**
     * @Route("/admin/searches", name="searches")
     */
    public function listAction(Environment $twig, SearchRepository $searchRep)
    {
        $searches = $searchRep->findAll();
        return new Response($twig->render('admin/search/list.html.twig',[
            'searches' => $searches,
        ]));
    }

    /**
     * @Route("/admin/searches/{id}", name="search_show")
     */
    public function showAction(Environment $twig,Search $search,RankRepository $rankRepository,TargetRepository $targetRepository)
    {
        $ranks = $rankRepository->findBy(array(
            'search' => $search
        ));
        $targets = $targetRepository->findAll();
        if (!$search) {
            throw $this->createNotFoundException(
                'No search found for id '.$search
            );
        }
        return new Response($twig->render('admin/search/view.html.twig', [
            'search' => $search,
            'ranks' => $ranks,
            'targets' => $targets
            ]));
    }

    /**
     * @Route("/admin/searches/edit/{id}", name="search_edit")
     */
    public function updateAction(Request $request,Search $search,FormFactoryInterface $searchForm)
    {
        $doctrine = $this->getDoctrine()->getManager();
        $form = $searchForm->createBuilder(SearchType::class, $search)->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $doctrine->persist($search);
            $doctrine->flush();
        }

        if (!$search) {
            throw $this->createNotFoundException(
                'No search found for id '.$search
            );
        }

        return $this->render(
            'admin/search/view.html.twig',
            array(
                'form' => $form->createView(),
                'search' => $search)
        );
    }

    /**
     * @Route("/admin/searches/delete/{id}", name="search_delete")
     */
    public function deleteAction(Search $search,Environment $twig, SearchRepository $searchsRep)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($search);
        $em->flush();

        $searches = $searchsRep->findAll();


        return new Response($twig->render('admin/search/list.html.twig',[
            'searches' => $searches
        ]));
    }
    /**
     * @Route("/searches/new", name="search_form")
     */
    public function addAction(Request $request, GroupRepository $groupRep)
    {
        $groups = $groupRep->findAll();
        // 1) build the form
        $search = new Search();

        $form = $this->createForm(SearchType::class, $search);

        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // 4) save theTarget!
            $em = $this->getDoctrine()->getManager();
            $em->persist($search);
            $em->flush();

            // ... do any other work - like sending them an email, etc
            // maybe set a "flash" success message for the target

            return $this->redirectToRoute('searches');
        }

        return $this->render(
            'admin/search/new.html.twig',
            array(
                'groups' => $groups,
                'form' => $form->createView())
        );
    }

}

