<?php

namespace App\Controller;


use App\Entity\Person;
use App\Entity\StoreImage;
use App\Form\ImageType;
use App\Form\PersonType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="main")
     */
    public function personform(Request $request): Response

    {


        return $this->render('main/form.html.twig', [
            
        ]);
    }

    /**
     * @Route("/save", name="mainsave")
     */
    public function saveForm(Request $request, $data): Response

    {
        $post = new Person();
        $form = $this->createForm(PersonType::class, $post);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();

            $this->addFlash('notice', 'Submitted Successfully');
        }

        return $this->render('main/person.html.twig', [
            'form' => $form->createView()
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


    /**
     * @Route("/uploadphoto", name="uploadphoto")
     */
    public function uploadphoto(Request $request): Response

    {
        $post = new StoreImage();
        $form = $this->createForm(ImageType::class, $post);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()) {
            $file = $post->getImage();
            $uploads_dir = $this->getParameter('uploads_dir');
            $filename = md5(uniqid()) . '.' . $file->guessExtension();
            $file->move(
                $uploads_dir,
                $filename
            );


            $em = $this->getDoctrine()->getManager();
            $em->setImage($filename);
            $em->persist($post);
            $em->flush();

            $this->addFlash('notice', 'Submitted Successfully');
        }

        return $this->render('main/uploadphoto.html.twig', [
            'form' => $form->createView()
        ]);
    }

}
