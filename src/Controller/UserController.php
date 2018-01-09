<?php

namespace App\Controller;


use App\Form\UserType;
use App\Repository\UserRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;


class UserController
{
    /**
     * @Route("/admin/users", name="users")
     */
    public function index(Request $request, Environment $twig, RegistryInterface $doctrine, UserRepository $usersRepository, FormFactoryInterface $userForm)
    {
        $users = $usersRepository->findAll();
        $form = $userForm->createBuilder(UserType::class)->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $doctrine->getEntityManager()->persist();
            $doctrine->getEntityManager()->flush();
        }

        return new Response($twig->render('admin/user.html.twig',[
            'users' => $users,
            'form' => $form->createView()
        ]));
    }
}
