<?php

namespace App\Controller\Group;


use App\Entity\Group;
use App\Form\GroupType;
use App\Repository\GroupRepository;
use App\Repository\SearchRepository;
use App\Repository\TargetRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use \howie6879\PhpGoogle\MagicGoogle;

class GroupController extends Controller
{
    /**
     * @Route("/admin/groups", name="groups")
     */
    public function listAction(Environment $twig, GroupRepository $groupsRep, TargetRepository $targetRep)
    {
        $groups = $groupsRep->findAll();

        return new Response($twig->render('admin/group/list.html.twig', [
            'groups' => $groups
        ]));
    }

    /**
     * @Route("/admin/groups/{id}", name="group_show")
     */
    public function showAction(Environment $twig, Group $group, TargetRepository $targetRep, SearchRepository $searchRep)
    {
        $searches = $searchRep->findBy(
            array('group' => $group)
        );
        $targets = $targetRep->findBy(
            array('group' => $group)
        );
        if (!$group) {
            throw $this->createNotFoundException(
                'No group found for id ' . $group
            );
        }
        return new Response($twig->render('admin/group/view.html.twig', [
            'group' => $group,
            'targets' => $targets,
            'searches' => $searches
        ]));
    }

    /**
     * @Route("/admin/groups/edit/{id}", name="group_edit")
     */
    public function updateAction(Request $request, group $group, FormFactoryInterface $groupForm)
    {
        $doctrine = $this->getDoctrine()->getManager();
        $form = $groupForm->createBuilder(GroupType::class, $group)->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $doctrine->persist($group);
            $doctrine->flush();
        }

        if (!$group) {
            throw $this->createNotFoundException(
                'No group found for id ' . $group
            );
        }

        return $this->render(
            'admin/group/view.html.twig',
            array(
                'form' => $form->createView(),
                'group' => $group)
        );
    }

    /**
     * @Route("/admin/groups/delete/{id}", name="group_delete")
     */
    public function deleteAction(group $group, Environment $twig, groupRepository $groupsRep)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($group);
        $em->flush();

        $groups = $groupsRep->findAll();


        return new Response($twig->render('admin/group/list.html.twig', [
            'groups' => $groups
        ]));
    }


    /**
     * @Route("/groups/new", name="group_form")
     */
    public function addAction(Request $request)
    {
        // 1) build the form
        $search = new Group();
        $form = $this->createForm(GroupType::class, $search);

        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            // 4) save theSearch!
            $em = $this->getDoctrine()->getManager();
            $em->persist($search);
            $em->flush();

            // ... do any other work - like sending them an email, etc
            // maybe set a "flash" success message for the search

            return $this->redirectToRoute('groups');
        }

        return $this->render(
            'admin/group/new.html.twig',
            array('form' => $form->createView())
        );
    }

    /**
     * @Route("/admin/groups/{id}/check",name="group_check")
     */
    public function checkRank()
    {
        $magicGoogle = new MagicGoogle();
        # Get {'title','url','text'}
        $data = $magicGoogle->search('python', 'en', '1');
        foreach ($data as $value) {
            var_dump($value);
        }

    }
}

