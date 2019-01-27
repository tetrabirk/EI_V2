<?php

namespace App\Controller;

use App\Entity\WorkDay;
use App\Form\WorkDay2Type;
use App\Form\WorkDaySearchType;
use App\Form\WorkDay1Type;
use App\Form\WorkDayType;
use App\Repository\WorkDayRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Dumper\GraphvizDumper;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Workflow\Exception\TransitionException;
use Symfony\Component\Workflow\Registry;

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
     * @param Request $request, Registry $workflows
     * @return Response
     */
    public function newWorkDayStepOne(Request $request, Registry $workflows):Response
    {
        $workday = new WorkDay();
        $workflow = $workflows->get($workday);

        $form = $this->createForm(WorkDayType::class, $workday, array(
            'places' => $workflow->getMarking($workday)->getPlaces()
        ));
        $form->handleRequest($request);

        //TODO make function out of this

        if ($form->isSubmitted() && $form->isValid()) {
            $workday = $form->getData();
            $workday->setAuthor($this->getUser());
            $entityManager = $this->getDoctrine()->getManager();

            if ($workflow->can($workday, 'add_basic_infos'))
            {
                $workflow->apply($workday, 'add_basic_infos');
                $entityManager->persist($workday);
               // $entityManager->flush();
            }

            return $this->forward('App\Controller\WorkDayController::newWorkDayStepTwo',array(
                'workday' => $workday,
            ));
        }
        return $this->render('workday/new_workday.html.twig',array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/new-entry-2/",name="new-workday-2")
     * @param Request $request, Registry $workflows
     * @return Response
     */
    public function newWorkDayStepTwo(Request $request, Registry $workflows, $workday = null):Response
    {
        dump($request);
        $workflow = $workflows->get($workday);
        $form = $this->createForm(WorkDayType::class, $workday, array(
            'places' => $workflow->getMarking($workday)->getPlaces()
        ));
        $form->handleRequest($request);

        //TODO make function out of this

        dump($workday);

        if ($form->get('summary')->isClicked() && $form->isSubmitted() && $form->isValid()) {

            $workday = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();

            if ($workflow->can($workday, 'add_completed_tasks'))
            {
                $workflow->apply($workday, 'add_completed_tasks');
                $entityManager->persist($workday);
                //$entityManager->flush();
            }

            return $this->forward('App\Controller\WorkDayController::newWorkDaySummary',array(
                'workday' => $workday,
            ));
        }

        return $this->render('workday/new_workday2.html.twig',array(
            'form' => $form->createView(),
            'workday' => $workday
        ));
    }

    /**
     * @Route("/new-entry-summary/",name="new-workday-3")
     * @param Request $request, Registry $workflows
     * @return Response
     */
    public function newWorkDaySummary(Request $request, Registry $workflows, $workday):Response
    {

        return $this->render('workday/summary.html.twig',array(
            'workday' => $workday,
        ));


    }
    /**
     * @Route("/new-entry-test/",name="new-workday-4")
     * @param Request $request
     * @return Response
     */
    public function newWorkDaytest(Request $request):Response
    {

        return $this->render('workday/test.html.twig',array(
            'test' => $request,
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
