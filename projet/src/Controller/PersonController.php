<?php

namespace App\Controller;

use App\Entity\Person;
use App\Form\PersonSearchType;
use App\Repository\PersonRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PersonController extends AbstractController
{
    /**
     * @Route("/person/{id}", defaults={"id"=null}, name="person")
     *
     * @param $id
     * @return Response
     */
    public function index($id):Response
    {
        if ($id !== null) {
            $person = $this->getRepo()->getOnePerson($id);

            return $this->render('person/person_detail.html.twig', array(
                'person' => $person,
            ));
        }

        $persons = $this->getRepo()->getPersonList();
        $form = $this->createForm(PersonSearchType::class);
//TODO make function out of this

        return $this->render('person/person_all.html.twig', array(
            'persons' => $persons,
            'form' => $form->createView(),
        ));


    }

    /**
     * @Route("/p-s/",name="person-search")
     * @param Request
     * @return Response
     */
    public function search(Request $request):Response{
        $search = $request->query->get('person_search');
        $searchString = $search['string'];
        $site = $search['site'] ?? null;
        $role = $search['role'] ?? null;
        $company= $search['company'] ?? null;


        $persons= $this->getRepo()->searchPersons($searchString,$site,$role,$company);
        dump($persons);
        $form = $this->createForm(PersonSearchType::class);
//TODO make function out of this

        return $this->render('person/person_all.html.twig', array(
            'persons' => $persons,
            'form' => $form->createView(),
        ));
    }

    public function getRepo():PersonRepository
    {
        /** @var PersonRepository $pr */
        $pr = $this->getDoctrine()->getRepository(Person::class);
        return $pr;

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
