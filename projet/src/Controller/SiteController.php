<?php

namespace App\Controller;

use App\Entity\Site;
use App\Entity\WorkDay;
use App\Form\SearchType;
use App\Repository\SiteRepository;
use App\Repository\WorkDayRepository;
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

        $form = $this->createForm(SearchType::class);
        return $this->render('site/site_all.html.twig', array(
            'sites' => $sites,
            'form' => $form->createView(),
        ));


    }

    /**
     * @Route("/s/",name="search")
     * @param Request
     * @return Response
     */
    public function search(Request $request):Response{
        dump($request);
        $searchString = $request->query->get('search')['string'];

        $sites= $this->getRepo()->searchSites($searchString);
        $form = $this->createForm(SearchType::class,array(
            'action' => $this->generateUrl('search'),
            'method' => 'GET',
        ));
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
}
