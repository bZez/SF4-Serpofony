<?php

namespace App\Controller\User;


use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UserController extends Controller
{
    /**
     * @Route("/admin/users", name="users")
     */
    public function listAction(Environment $twig, UserRepository $usersRep)
    {
        $users = $usersRep->findAll();


        return new Response($twig->render('admin/user/list.html.twig',[
            'users' => $users
        ]));
    }

    /**
     * @Route("/admin/users/{id}", name="user_show")
     */
    public function showAction(Environment $twig,User $user)
    {
        if (!$user) {
            throw $this->createNotFoundException(
                'No user found for id '.$user
            );
        }
       return new Response($twig->render('admin/user/view.html.twig', ['user' => $user]));
    }

    /**
     * @Route("/admin/users/edit/{id}", name="user_edit")
     */
    public function updateAction(Request $request,User $user,FormFactoryInterface $userForm)
    {
        $doctrine = $this->getDoctrine()->getManager();
        $form = $userForm->createBuilder(UserType::class, $user)->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $doctrine->persist($user);
            $doctrine->flush();
        }

        if (!$user) {
            throw $this->createNotFoundException(
                'No user found for id '.$user
            );
        }

        return $this->render(
            'admin/user/edit.html.twig',
            array(
                'form' => $form->createView(),
                'user' => $user)
        );
    }

    /**
     * @Route("/admin/users/delete/{id}", name="user_delete")
     */
    public function deleteAction(User $user,Environment $twig, UserRepository $usersRep)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($user);
        $em->flush();

        $users = $usersRep->findAll();


        return new Response($twig->render('admin/user/list.html.twig',[
            'users' => $users
        ]));
    }

}

