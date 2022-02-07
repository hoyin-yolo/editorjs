<?php

namespace App\Controller;
require '../vendor/autoload.php';

use Aws\Translate\TranslateClient as Client; 
use Aws\Exception\AwsException;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Stichoza\GoogleTranslate\GoogleTranslate;

class TController extends AbstractController
{
    /**
     * @Route("/trans", name="t")
     */
    public function index(): Response
    {
        $ss = "";
        $post = "早起きは三文の徳";
        $tw = new GoogleTranslate('zh-TW');
        $en = new GoogleTranslate('en');
        $kr = new GoogleTranslate('ko');
        $vn = new GoogleTranslate('vn');
        $pt = new GoogleTranslate('pt');

        $ss .= $tw->translate($post);
        $ss .= $en->translate($post);
        $ss .= $kr->translate($post);
        $ss .= $vn->translate($post);
        $ss .= $pt->translate($post);

        return $this->render('t/index.html.twig', [
            'ss' => $ss,

        ]);
    }

    

    /**
     * @Route("/aws", name="aws")
     */
    public function aws(): Response
    {
        $result = "Start...";

        //Create a Translate Client
        $client = new Client([
            'region' => 'us-west-2',
            'version' => '2017-07-01'
        ]);

        try {
            $result = $client->translateText([
                'SourceLanguageCode' => 'en',
                'TargetLanguageCode' => 'jp', 
                'Text' => 'I am going to bed.', 
            ]);
        }catch (AwsException $e) {
            // output error message if fails
            echo $e->getMessage();
            echo "\n";
        }

        return $this->render('t/index.html.twig', [
            'ss' => $result,
        ]);
    }
}
