<?php

namespace App\DataFixtures;

use App\Entity\CompletedTask;
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
        for($i=0;$i<self::MAX_AMOUNT_OF_WORKDAYS;$i++){

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
            $workDay->setDate($this->faker->dateTimeBetween('-3 years', 'now'));
            $workDay->setComment($this->faker->optional(0.2)->text(140));

            //TODO photo

            $this->addTasksToWorkers($manager, $workers, $siteRefNbr);

            $this->addRefToIndex(self::REF_WORK_DAY,$workDay,$i);
            $manager->persist($workDay);
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

    public  function addTasksToWorkers(ObjectManager $manager, array $workers, int $siteRefNbr)
    {
        foreach ($workers as $worker){
            /** @var $worker Worker */

            $this->addCompletedTasks($manager, $worker, $siteRefNbr);
            $manager->persist($worker);
        }
    }

    public function addCompletedTasks(ObjectManager $manager, Worker $worker, int $siteRefNbr)
    {
        $times = $this->randomTime();

        for ($k = 0; $k < count($times); $k++) {
            $completedTask = new CompletedTask();
            $taskRefs= self::$referencesIndex[self::REF_TASK][$siteRefNbr];
            /** @var $task Task* */
            $task = $this->getReference(self::REF_TASK.'_' . $siteRefNbr .'_'. $taskRefs[array_rand($taskRefs)]);
            $completedTask->setTask($task);

            $duration = new \DateTime();
            $duration->setTime(0, $times[$k], 0);
            $completedTask->setDuration($duration);

            $worker->addCompletedTask($completedTask);
            /**@var $wd WorkDay* */
            $manager->persist($completedTask);
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
}