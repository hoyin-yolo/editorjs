<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="main")
     */
    public function index(): Response
    {
        $msg = ['<h1>My Post</h1><ul><li>Apple</li><li>Banana</li><li>Orange</li></ul>', '<h5>Nobushoten</h5>', '<iframe width="560" height="315" src="https://www.youtube.com/embed/OK_JCtrrv-c" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe><p>This is PHP tutorial</p>'];
        return $this->render('main/index.html.twig', [
            "msg" => $msg,
        ]);
    }


    /**
     * @Route("/create", name="create")
     */
    public function create(): Response
    {
        return $this->render('main/create.html.twig', [

        ]);
    }


    /**
     * @Route("/edit", name="edit")
     */
    public function edit(): Response
    {
        $tokens = array();
        $msg = "<h1>My Post</h1><ul><li>Apple</li><li>Banana</li><li>Orange</li></ul>";
        preg_match_all('/<[^>]++>|[^<>\s]++/', $msg, $tokens);
        return $this->render('main/edit.html.twig', [
            "msg" => $msg,
            "tokens" => $tokens,
        ]);
    }

}
