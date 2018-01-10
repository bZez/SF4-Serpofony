<?php

namespace App\Controller\Search;


use App\Entity\Search;
use App\Form\SearchType;
use App\Repository\SearchRepository;
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
            'searches' => $searches
        ]));
    }

    /**
     * @Route("/admin/searches/{id}", name="search_show")
     */
    public function showAction(Environment $twig,Search $search)
    {
        if (!$search) {
            throw $this->createNotFoundException(
                'No search found for id '.$search
            );
        }
        return new Response($twig->render('admin/search/view.html.twig', ['search' => $search]));
    }

    /**
     * @Route("/admin/searches/edit/{id}", name="search_edit")
     */
    public function updateAction(Request $request,search $search,FormFactoryInterface $searchForm)
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
    public function deleteAction(search $search,Environment $twig, searchRepository $searchsRep)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($search);
        $em->flush();

        $searchs = $searchsRep->findAll();


        return new Response($twig->render('admin/search/list.html.twig',[
            'searchs' => $searchs
        ]));
    }

}

