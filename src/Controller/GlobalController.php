<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class GlobalController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function index()
    {
        return $this->render('index.html.twig');
    }

    /**
     * @Route("/admin", name="admin")
     */
    public function admin(Environment $twig, UserRepository $usersRep)
    {
        $users = $usersRep->findAll();


        return new Response($twig->render('admin/user/list.html.twig',[
            'users' => $users
        ]));
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logout() {
        $this->get('security.token_storage')->setToken(null);
        $this->get('request')->getSession()->invalidate();

        return $this->redirect($this->generateUrl('homepage'));
    }
}
