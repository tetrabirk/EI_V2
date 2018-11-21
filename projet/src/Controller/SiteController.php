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
     * @Route("/{id}", defaults={"id"=null}, name="site")
     *
     * @param $id
     * @return Response
     */
    public function index($id)
    {
        if ($id !== null) {
            $test = $this->getRepo()->getOneWorkDay($id);

            return $this->render('site/index.html.twig', array(
                'test' => $test,
            ));
        }

        $test = $this->getRepo()->getWorkdayList();

        return $this->render('site/index.html.twig', array(
            'test' => $test,
        ));


    }

    public function getRepo()
    {
//        /** @var SiteRepository $sr */
//        $sr = $this->getDoctrine()->getRepository(Site::class);
//        return $sr;

        /** @var WorkDayRepository $sr */
        $sr = $this->getDoctrine()->getRepository(WorkDay::class);
        return $sr;
    }
}
