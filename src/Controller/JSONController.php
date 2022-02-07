<?php

namespace App\Controller;

use App\Entity\JSONPost;
use App\Form\JSONType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class JSONController extends AbstractController
{
    

    /**
     * @Route("/json", name="json")
     */
    public function index(): Response

    {
       
        return $this->render('json/index.html.twig', [
            
        ]);
    }


    /**
     * @Route("/json/view", name="jsonview")
     */
    public function view(): Response
    {
        $posts = $this->getDoctrine()->getRepository(JSONPost::class)->findBy([], ['id' => 'DESC']);
        return $this->render('json/view.html.twig', [
            'posts' => $posts
        ]);
    }


    /**
     * @Route("/json/edit/{id}", name="jsonedit")
     */
    public function edit(Request $request, $id): Response
    {
        $post = $this->getDoctrine()->getRepository(JSONPost::class)->find($id);
        $form = $this->createForm(JSONType::class, $post);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();

            $this->addFlash('notice', 'Submitted Successfully');
        }

        return $this->render('json/edit.html.twig', [
            'form' => $form->createView(),
            'post' => $post
        ]);
    }


    /**
     * @Route("/json/delete/{id}", name="jsondelete")
     */
    public function delete(Request $request, $id): Response
    {
        $post = $this->getDoctrine()->getRepository(JSONPost::class)->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($post);
        $em->flush();
        
        $this->addFlash('notice', 'Submitted Successfully');

        return $this->redirectToRoute('jsonview');
    }


    /**
     * @Route("/json/create", name="jsoncreate")
     */
    public function create(Request $request): Response

    {
        $post = new JSONPost();
        $form = $this->createForm(JSONType::class, $post);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()) {
            

            $file = $request->files->get('json')['image'];
            $uploads_dir = $this->getParameter('uploads_dir');
            $filename = md5(uniqid()) . '.' . $file->guessExtension();
            $file->move(
                $uploads_dir,
                $filename
            );

            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();

            $this->addFlash('notice', 'Submitted Successfully');
        }

        return $this->render('json/create.html.twig', [
            'form' => $form->createView()
        ]);
    }



    /**
     * @Route("/json/upload", name="jsonupload")
     */
    public function upload(Request $request): Response
    {
        $file = $request->files->all();
        $x = $file['test'];
        var_dump($x);
        die;
    }

}
