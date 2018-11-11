<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;
use Cocur\Slugify\Slugify;


abstract class BaseFixtures extends Fixture
{
    const AMOUNT_OF_SITES = 10;
    const AMOUNT_OF_PERSONS = 50;
    const AMOUNT_OF_WORKERS = 20;
    const AMOUNT_OF_AUTHORS = 5; //must be < than AMOUNT_OF_WORKERS
    const MAX_AMOUNT_OF_WORKDAYS = 50;
    const AMOUNT_OF_MATERIALS = 50;

    const MIN_AMOUNT_L1_TASK=7;
    const MAX_AMOUNT_L1_TASK=15;

    const MIN_AMOUNT_L2_TASK=0;
    const MAX_AMOUNT_L2_TASK=5;

    const MIN_AMOUNT_OF_WORKERS_ON_WORKDAY =0; //author not included
    const MAX_AMOUNT_OF_WORKERS_ON_WORKDAY =2; //author not included

    const COMPANY_NAME = 'Concept Eco-Logis';
    const REF_SITE = "site";
    const REF_TASK = "task";
    const REF_PERSON = "person";
    const REF_ADMIN = "admin";
    const REF_WORKER = "worker";
    const REF_AUTHOR = "author";
    const REF_COMPLETED_TASK = "completed_task";
    const REF_WORK_DAY = "work_day";

    protected static $personTypes = ['architecte','fournisseur','client'];
    protected static $materialTypes = ['panneaux','chevrons','préfabriqués','pierre','sac','tuyauterie'];

    protected static $countries = ['Belgium', 'Germany', 'Luxembourg'];

    /** @var ObjectManager */
    private $manager;
    /** @var Generator */
    protected $faker;

    /**@var \Cocur\Slugify\SlugifyInterface**/
    protected $slugify;

    protected static $referencesIndex = [];


    abstract protected function loadData(ObjectManager $manager);

    public function load(ObjectManager $manager)
    {
        $this->manager = $manager;
        $this->faker = Factory::create('fr_BE');
        $this->loadData($manager);

    }

    public function addRefToIndex($className,$object,$i,$ref = null)
    {
        if ($ref === null){
            if (!isset($this->referencesIndex[$className])) {
                self::$referencesIndex[$className] = [];
            }
            $this->addReference($className.'_'.$i, $object);
            array_push( self::$referencesIndex[$className], $i);

        }else{
            if (!isset($this->referencesIndex[$className][$i])) {
                self::$referencesIndex[$className][$i] = [];
            }
            $this->addReference($className.'_'.$i.'_'. $ref, $object);
            array_push( self::$referencesIndex[$className][$i], $ref);

        }
    }
    public function randNumberArray(int $min,int $max,int $size){
        $random_number_array = range($min, $max);
        shuffle($random_number_array );
        $random_number_array = array_slice($random_number_array ,0,$size);
        return $random_number_array;
    }

//    public function genReferencesIndex(){
//        $repoArray = ($this->referenceRepository->getReferences());
//        $refRepo = array_keys($repoArray);
//
//        $refIndex = [];
//        foreach ($refRepo as $ref){
//            $refArray = explode('_',$ref);
//            $className=array_shift($refArray);
//            if (!isset($refIndex[$className]))
//            {
//                $refIndex[$className]=[];
//            }
//            if(count($refArray)>1){
//                if(!isset($refIndex[$className][$refArray[0]])){
//                    $refIndex[$className][$refArray[0]] = [];
//                }
//                array_push($refIndex[$className][array_shift($refArray)],$refArray);
//            }else{
//                array_push($refIndex[$className],$refArray[0]);
//            }
//      }
//        return $refIndex;
//    }
}
