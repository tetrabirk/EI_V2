<?php

namespace App\DataFixtures;

use App\Entity\CompletedTask;
use App\Entity\Flag;
use App\Entity\Site;
use App\Entity\Task;
use App\Entity\WorkDay;
use App\Entity\Worker;
use Cocur\Slugify\Slugify;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class WorkDayFixtures extends BaseFixtures implements DependentFixtureInterface
{

    public function loadData(ObjectManager $manager)
    {
        $this->genWorkdays($manager);

        $manager->flush();
    }

    public function genWorkdays(ObjectManager $manager)
    {
        $dates = $this->genDatesArray(self::MAX_AMOUNT_OF_WORKDAYS);
        $i=0;
        foreach ($dates as $date){

            $workers = $this->getRandAmountOfWorkers();
            /** @var $author Worker */
            $author = $this->getRandAuthor();

            /** @var $site Site */
            $siteRefNbr = rand(1,self::AMOUNT_OF_SITES)-1;
            $site = $this->getReference(self::REF_SITE.'_'.$siteRefNbr);


            if(!in_array($author,$workers)){
                array_push($workers,$author);
            }

            $workDay = new WorkDay();

            $workDay->setAuthor($author);
            $workDay->setSite($site);
            $workDay->setDate($date);
            $workDay->setState("unvalidated");
            $workDay->setComment($this->faker->optional(0.2)->text(140));
            //TODO photo
            $this->addFlag($manager,$workDay);

            $this->addTasksToWorkers($manager, $workDay, $workers, $siteRefNbr);

            $this->addRefToIndex(self::REF_WORK_DAY,$workDay,$i);
            $site->addWorkDay($workDay);
            //TODO add participation (if SiteXWorker not exist -> new participation)
            if($i===0){
                $site->setfirstWorkDay($date);
            }
            $site->setlastWorkDay($date);
            $manager->persist($site);
            $manager->persist($workDay);
            $i++;
        }
    }

    public function getRandAmountOfWorkers()
    {
        $randAmountOfWorkers=rand(self::MIN_AMOUNT_OF_WORKERS_ON_WORKDAY,self::MAX_AMOUNT_OF_WORKERS_ON_WORKDAY);
        $workers = [];
        $randRefArray=$this->randNumberArray(0,self::AMOUNT_OF_WORKERS-1,$randAmountOfWorkers);
        foreach ($randRefArray as $ref) {
            $worker = $this->getReference(self::REF_WORKER.'_' . $ref);
            array_push($workers, $worker);
        }
        return $workers;
    }

    public function getRandAuthor()
    {
        $author=$this->getReference(self::REF_AUTHOR.'_'.rand(0,self::AMOUNT_OF_AUTHORS-1));
        return $author;
    }

    public  function addTasksToWorkers(ObjectManager $manager, WorkDay $workDay, array $workers, int $siteRefNbr)
    {
        foreach ($workers as $worker){
            /** @var $worker Worker */

            $this->addCompletedTasks($manager, $workDay,  $worker, $siteRefNbr);
            $manager->persist($worker);
        }
    }

    public function addCompletedTasks(ObjectManager $manager, WorkDay $workDay, Worker $worker, int $siteRefNbr)
    {
        $times = $this->randomTime();

        foreach ($times as $time) {
            $completedTask = new CompletedTask();
            $taskRefs= self::$referencesIndex[self::REF_TASK][$siteRefNbr];
            /** @var $task Task* */
            $task = $this->getReference(self::REF_TASK.'_' . $siteRefNbr .'_'. $taskRefs[array_rand($taskRefs)]);
            $completedTask->setTask($task);

            $duration = new \DateTime();
            $duration->setTime(0, $time, 0);
            $completedTask->setDuration($duration);
            $task->addCompletedTask($completedTask);
            $worker->addCompletedTask($completedTask);
            $completedTask->setWorker($worker);
            $completedTask->setWorkday($workDay);
            $workDay->addWorker($worker);
            $manager->persist($completedTask);
            $manager->persist($worker);
            $manager->persist($workDay);
        }
    }

    public function addFlag(ObjectManager $manager, WorkDay $workDay)
    {
        $array=[0,0,0,0,0,1,1,2,2,3];
        $key =array_rand($array);
        $rand =$array[$key];

        for ($i=0; $i<$rand; $i++)
        {
            $flag = new Flag;
            $flag->setComment($this->faker->text($maxNbChars = 255));
            $flag->setWorkDay($workDay);
            $flag->setViewed(random_int(0,1));
            $workDay->addFlag($flag);
            $workDay->setFlagged(1);
            $workDay->setState("flagged");
            $workDay->setValidated(true);
            $manager->persist($flag);
        }
    }


    public function randomTime()
    {
        $t = [];
        while (array_sum($t) < 360) {
            array_push($t, (rand(3, 6) * 30));
        }
        return $t;
    }

    public function getDependencies()
    {
        return array(
            UserFixtures::class,
            SiteFixtures::class,
        );
    }
    public function genDatesArray($amount){
        $dates = [];
        for ($i=0; $i<$amount; $i++){
            $dates[$i] = $this->faker->dateTimeBetween('-3 years', 'now');
        }
        sort($dates);
        return $dates;
    }

}
