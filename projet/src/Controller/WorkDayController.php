<?php

namespace App\Controller;

use App\Entity\WorkDay;
use App\Form\WorkDaySearchType;
use App\Form\WorkDayType;
use App\Repository\WorkDayRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Workflow\Registry;

class WorkDayController extends AbstractController
{

    private $workFlows;

    public function __construct(Registry $workFlows)
    {
        $this->workFlows = $workFlows;
    }


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

        return $this->render('workday/workday_all.html.twig', array(
            'workDays' => $workDays,
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/s-wd/",name="wd-search")
     * @param Request $request
     * @return Response
     */
    public function search(Request $request):Response{

        $search = $request->query->get('work_day_search');

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

        return $this->render('workday/workday_all.html.twig', array(
            'workdays' => $workDays,
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/new-workday/",name="new-workday")
     * @param Request $request
     * @return Response
     */
    public function newWorkDay(Request $request):Response
    {
        $workday = new WorkDay();

        $form = $this->createForm(WorkDayType::class, $workday);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $workday = $form->getData();
            $workday->setAuthor($this->getUser());

            $this->changeState($workday,'add_basic_infos');

            return $this->forward('App\Controller\WorkDayController::addCompletedTasks',array(
                'workdayId' => $workday->getId(),
            ));
        }

        return $this->render('workday/new_workday.html.twig',array(
            'form' => $form->createView()
        ));
    }

    public function handleForm()
    {
        //TODO à voire
    }

    /**
     * @Route("/add-completed-tasks/{workdayId}", defaults={"workdayId"=null} ,name="add-completed-tasks")
     * @param $workdayId
     * @param Request $request
     * @return Response
     */
    public function addCompletedTasks(Request $request, $workdayId):Response
    {
        if($workdayId !==null) {
            $workday = $this->getRepo()->findOneBy(['id'=>$workdayId]);
        }else{
            $workday = new WorkDay();
        }

        $form = $this->createForm(WorkDayType::class, $workday);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $workday = $form->getData();

            $this->changeState($workday,'add_completed_tasks');

            return $this->forward('App\Controller\WorkDayController::summary',array(
                'workday' => $workday,
            ));
        }

        return $this->render('workday/add_completed_tasks.html.twig',array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/workday-summary/",name="workday-summary")
     * @param WorkDay $workday
     * @return Response
     */
    public function summary($workday):Response
    {
        return $this->render('workday/summary.html.twig',array(
            'workday' => $workday,
        ));
    }
    /**
     * @Route("/workday-edit/{workdayId}", defaults={"workdayId"=null},name="workday-edit")
     * @param $workdayId
     * @param Request $request
     * @return Response
     */
    public function edition(Request $request, $workdayId):Response
    {
        $workday = $this->getWorkday($workdayId);

        dump($this->getUser());
        if($this->getUser()->isGranted('ROLE_ADMIN')){ //I Dont know if i can do this
            $this->changeState($workday,'modify_admin');
        }else{
            $this->changeState($workday,'modify');
        }

        $form = $this->createForm(WorkDayType::class, $workday);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $workday = $form->getData();

            $this->changeState($workday,'add_basic_infos');

            return $this->forward('App\Controller\WorkDayController::addCompletedTasks',array(
                'workdayId' => $workday->getId(),
            ));
        }

        return $this->render('workday/edit_workday.html.twig',array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/new-entry-summary/",name="workday-summary")
     * @param WorkDay $workday
     * @return Response
     */
    public function workDaySummary(WorkDay $workday):Response
    {

        return $this->render('workday/summary.html.twig',array(
            'workday' => $workday,
        ));
    }

    /**
     * @Route("/workday-submit/{workdayId}", defaults={"workdayId"=null},name="workday-submit")
     * @param $workdayId
     * @return Response
     */
    public function submit($workdayId):Response
    {
        $workday = $this->getWorkday($workdayId);

        if($this->getUser()->isGranted('ROLE_ADMIN')){ //I Dont know if i can do this
            $this->changeState($workday,'validated');
        }else{
            $this->changeState($workday,'unvalidated');
        }

        return $this->forward('App\Controller\BaseController::homepage');
    }

    private function getWorkday($id)
    {
        if($id !==null) {
            return $this->getRepo()->findOneBy(['id'=>$id]);
        }
        return $this->forward('App\Controller\WorkDayController::newWorkDay');

    }

    /**
     * @param $workday
     * @param $state
     * @return bool
     */
    private function changeState($workday,$transition):bool
    {
        $entityManager = $this->getDoctrine()->getManager();
        $workFlow = $this->workFlows->get($workday);

        if ($workFlow->can($workday, $transition))
        {
            $workFlow->apply($workday, $transition);
            $entityManager->persist($workday);
            $entityManager->flush();
            return true;
        }

        return false;
    }


    private function getRepo():WorkDayRepository
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
