<?php

namespace App\Controller;

use App\Entity\Site;
use App\Form\SiteSearchType;
use App\Repository\SiteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
    public function index($id):Response
    {
        if ($id !== null) {
            $site = $this->getRepo()->getOneSite($id);

            return $this->render('site/site_detail.html.twig', array(
                'site' => $site,
            ));
        }

        $sites = $this->getRepo()->getSiteList();
        $form = $this->createForm(SiteSearchType::class);
//TODO make function out of this

        return $this->render('site/site_all.html.twig', array(
            'sites' => $sites,
            'form' => $form->createView(),
        ));


    }

    /**
     * @Route("/s-s/",name="site-search")
     * @param Request
     * @return Response
     */
    public function search(Request $request):Response{
        $search = $request->query->get('site_search');
        $searchString = $search['string'];
        $firstDayMin = $this->arrayToDate($search['firstDayMin']);
        $firstDayMax = $this->arrayToDate($search['firstDayMax']);
        $lastDayMin = $this->arrayToDate($search['lastDayMin']);
        $lastDayMax = $this->arrayToDate($search['lastDayMax']);
        $distance = $search['distance'];
        $finished = $search['finished'];
        $active = $search['active'];
        $flagged = $search['flagged'];
        dump($finished);

        $sites= $this->getRepo()->searchSites($searchString, $firstDayMin,$firstDayMax,$lastDayMin,$lastDayMax,$distance,$finished,$active,$flagged);

        $form = $this->createForm(SiteSearchType::class);
//TODO make function out of this

        return $this->render('site/site_all.html.twig', array(
            'sites' => $sites,
            'form' => $form->createView(),
        ));
    }

    public function getRepo():SiteRepository
    {
        /** @var SiteRepository $sr */
        $sr = $this->getDoctrine()->getRepository(Site::class);
        return $sr;

    }
    //TODO make a service out of this
    public function arrayToDate($array){
        if ($array['year'] === '' || $array['month'] === ''|| $array['day'] === '' ){
            return null;
        }else{
            $y = $array['year'] ?? '0000';
            $m = $array['month'] ?? '00';
            $d = $array['day'] ?? '00';

            return new \DateTime($y.'-'.$m.'-'.$d);
        }

    }
}
