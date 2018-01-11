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
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

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
    /**
     * @Route("/register", name="user_form")
     */
    public function registerAction(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        // 1) build the form
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            // 3) Encode the password (you could also do this via Doctrine listener)
            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);

            // 4) save the User!
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            // ... do any other work - like sending them an email, etc
            // maybe set a "flash" success message for the user

            return $this->redirectToRoute('homepage');
        }

        return $this->render(
            'registration/register.html.twig',
            array('form' => $form->createView())
        );
    }
}

