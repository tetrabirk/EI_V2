<?php

namespace App\Controller;

use App\Entity\Site;
use App\Entity\WorkDay;
use App\Repository\SiteRepository;
use App\Repository\WorkDayRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SiteController extends AbstractController
{
    /**
     * @Route("/site/{id}", defaults={"id"=null}, name="site")
     *
     * @param $id
     * @return Response
     */
    public function index($id)
    {
        if ($id !== null) {
            $site = $this->getRepo()->getOneSite($id);

            return $this->render('site/site_detail.html.twig', array(
                'site' => $site,
            ));
        }

        $sites = $this->getRepo()->getSiteList();

        return $this->render('site/site_all.html.twig', array(
            'sites' => $sites,
        ));


    }

    public function getRepo()
    {
        /** @var SiteRepository $sr */
        $sr = $this->getDoctrine()->getRepository(Site::class);
        return $sr;

    }
}
