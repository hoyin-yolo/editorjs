<?php

namespace Company\IndexBundle\Controller\Company;

use Company\IndexBundle\Entity\CompanyBlog;
use Company\IndexBundle\Form\CompanyBlogType;
use Company\IndexBundle\Manager\CompanyBlogManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Happyr\DoctrineSpecification\Spec;
use IndexBundle\File\UploadedFile as YoloFile;

/**
 * ブログ管理
 *
 * @Route("/blog")
 */
class BlogController extends Controller
{
    /**
     * 一覧
     *
     * @Route("/{page}", defaults={"page": 1}, requirements={"page": "\d+"}, name="company_blog")
     * @param Request $request
     * @param int $page
     * @return Response
     */
    public function indexAction(Request $request, int $page)
    {
        $blogs = $this->getCompanyBlogManager()->findAllByCompany($this->getUser()->getCompany());

        return $this->render('@CompanyIndex/Company/Blog/index.html.twig', [
            'blogs' => $blogs,
            
        ]);
    }

    /**
     * 詳細
     *
     * @Route("/details/{id}", requirements={"id": "\d+"}, name="company_blog_details")
     * @param Request $request
     */
    public function detailsAction(Request $request, int $id)
    {
        $blog = $this->getCompanyBlogManager()->findOneByCompany($id, $this->getUser()->getCompany());
        $converted = $this->getCompanyBlogManager()->convertToHTML($blog->getBody());
        $time = $this->getCompanyBlogManager()->getBlogTime($blog->getBody());

        if (!$blog) {
            // error
        }

        return $this->render('@CompanyIndex/Company/Blog/details.html.twig', [
            'blog' => $blog,
            'converted' => $converted,
            'time' => $time,
        ]);
    }

    /**
     * 新規登録
     *
     * @Route("/add", name="company_blog_add")
     * @param Request $request
     * @return Response
     */
    public function addAction(Request $request)
    {
        $form = $this->createForm(CompanyBlogType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var CompanyBlog $blog */
            $blog = $form->getData();
            $blog->setCompany($this->getUser()->getCompany());
            $blog = $this->getCompanyBlogManager()->add($blog);

            $this->addFlash('notice', '新なブログ作成しました！');
            return $this->redirectToRoute('company_blog', ['id' => $blog->getId()]);
        }

        return $this->render('@CompanyIndex/Company/Blog/input.html.twig', [
            'form' => $form->createView(),
            'submit_button' => "登録",
        ]);
    }

    /**
     * 編集
     *
     * @Route("/edit/{id}", requirements={"id": "\d+"}, name="company_blog_edit")
     * @param Request $request
     */
    public function editAction(Request $request, int $id)
    {
        $blog = $this->getCompanyBlogManager()->findOneByCompany($id, $this->getUser()->getCompany());
        $form = $this->createForm(CompanyBlogType::class, $blog);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($blog);
            $em->flush();

            $this->addFlash('notice', '編集成功しました！');
            return $this->redirectToRoute('company_blog_details', ['id' => $blog->getId()]);
        }


        return $this->render('@CompanyIndex/Company/Blog/input.html.twig', [
            'form' => $form->createView(),
            'submit_button' => "編集",
        ]);
    }



    // This is will be set in config/services.yaml for storing images
    // Storing location e.g. 'public/uploads/' has yet been set
    // e.g.
    // parameters:
    //    uploads_dir: '%kernel.project_dir%/public/uploads'
    /**
     * 画像添付
     *
     * @Route("/uploadImage", name="company_blog_uploadImage")
     * @param Request $request
     */
    public function uploadImage(Request $request)
    {
        $show = $request->files->get('image');
        $yoloFile = new YoloFile(); 
        $fileName = $yoloFile->tempUpload($show);


        // var_dump($fileName); die;
        
        
        return new \IndexBundle\Component\HttpFoundation\JsonResponse(['success' => 1, 'file' => ['url' => '/uploads/temp/' . $fileName]]);

        /*
         * Save path: 
         *
        $file = $request->files->all();
        var_dump($file); die;
        $uploads_dir = $this->getParameter('uploads_dir');
        $filename = md5(uniqid()) . '.' . $file->guessExtension();
        $file->move(
            $uploads_dir,
            $filename
        );
        $fileurl = $uploads_dir + $filename;        

        */

    }

    

    /**
     * 削除
     *
     * @Route("/delete/{id}", name="company_blog_delete")
     * @param Request $request
     */
    public function deleteAction(Request $request, int $id)
    {
        $blog = $this->getCompanyBlogManager()->findOneByCompany($id, $this->getUser()->getCompany());
        $em = $this->getDoctrine()->getManager();
        $em->remove($blog);
        $em->flush();
        
        $this->addFlash('notice', '削除しました！');

        return $this->redirectToRoute('company_blog');
    }

    protected function getCompanyBlogManager(): CompanyBlogManager
    {
        return $this->get('company.manager.company_blog');
    }
}
