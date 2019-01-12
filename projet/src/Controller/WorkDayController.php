<?php

namespace App\Controller;

use App\Entity\WorkDay;
use App\Form\WorkDay2Type;
use App\Form\WorkDaySearchType;
use App\Form\WorkDay1Type;
use App\Repository\WorkDayRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WorkDayController extends AbstractController
{
    /**
     * @Route("/workday/{id}", defaults={"id"=null}, name="workday")
     *
     * @param $id
     * @return Response
     */
    public function index($id):Response
    {
        if ($id !== null) {
            $workDay = $this->getRepo()->getOneWorkDay($id);

            return $this->render('workday/workday_detail.html.twig', array(
                'workDay' => $workDay,
            ));
        }

        $workDays = $this->getRepo()->getWorkdayList();
        $form = $this->createForm(WorkDaySearchType::class);
//TODO make function out of this
        return $this->render('workday/workday_all.html.twig', array(
            'workdays' => $workDays,
            'form' => $form->createView(),
        ));


    }

    /**
     * @Route("/s-wd/",name="wd-search")
     * @param Request
     * @return Response
     */
    public function search(Request $request):Response{

        $search = $request->query->get('work_day_search');
        dump($request);
        //TODO make function out of this

        $dateMin = $this->arrayToDate($search['dateMin']);
        $dateMax = $this->arrayToDate($search['dateMax']);
        $site = $search['site'] ?? null;
        $author = $search['author'] ?? null;
        $workers = $search['workers'] ?? null;
        $validated = $search['validated'] ?? null;
        $flagged = $search['flagged'] ?? null;

        $workDays= $this->getRepo()->searchWorkDays($dateMin,$dateMax,$site,$author,$workers,$validated,$flagged);
        $form = $this->createForm(WorkDaySearchType::class);
//TODO make function out of this

        return $this->render('workday/workday_all.html.twig', array(
            'workdays' => $workDays,
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/new-entry/",name="new-workday")
     * @param Request
     * @return Response
     */
    public function newWorkDay(Request $request):Response
    {
        dump($request);
        //todo : add "&& is valid blablabla"
        $form1 = $this->createForm(WorkDay1Type::class);

        $form1->handleRequest($request);

        if ($form1->isSubmitted() && $form1->isValid()) {

            $workday = $form1->getData();
            $form2 = $this->createForm(WorkDay2Type::class,$workday);

            //TODO make function out of this
            return $this->render('workday/new_workday.html.twig',array(
                'form' => $form2->createView(),
            ));
        }

        //TODO make function out of this
        return $this->render('workday/new_workday.html.twig',array(
            'form' => $form1->createView(),
        ));

    }

    public function getRepo():WorkDayRepository
    {
        /** @var WorkDayRepository $wdr */
        $wdr = $this->getDoctrine()->getRepository(WorkDay::class);
        return $wdr;

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
