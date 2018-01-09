<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class GlobalController extends Controller
{
    /**
     * @Route("/", name="global")
     */
    public function index()
    {
        return $this->render('index.html.twig');
    }
}
