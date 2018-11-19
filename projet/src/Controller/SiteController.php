<?php

namespace App\Controller;

use App\Entity\Site;
use App\Repository\SiteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SiteController extends AbstractController
{
    /**
     * @Route("/", name="site")
     */
    public function index()
    {
        $sites= $this->getDoctrine()
            ->getRepository(Site::class)
            ->testbyShortName('VBH');

        return $this->render('site/index.html.twig',array(
           'sites'=>$sites,
        ));

    }
}
