<?php

namespace App\DataFixtures;

use App\Entity\WorkDay;
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
            $workDay = new WorkDay();

            $workers = $this->getRandAmountOfWorkers();
            $author = $this->getRandAuthor();

            array_push($workers,$author);

            $workDay = new WorkDay();
            $this->addRefToIndex('workDay',$workDay,$i,$j);

            $workDay->setAuthor($author);
            $workDay->setSite($site);
            $workDay->setDate($this->faker->dateTimeBetween('-3 years', 'now'));
            $workDay->setComment($this->faker->optional(0.2)->text(140));

            //TODO photo

            $this->genCompletedTasks($manager ,$workers,$i,$j);


            $this->addRefToIndex(self::REF_WORK_DAY,$workDay,$i);
            $manager->persist($workDay);
        }
    }

    public function getRandAmountOfWorkers(){
        $randAmountOfWorkers=rand(self::MIN_AMOUNT_OF_WORKERS_ON_WORKDAY,self::MAX_AMOUNT_OF_WORKERS_ON_WORKDAY);
        $workers = [];
        for ($l = 0; $l < $randAmountOfWorkers; $l++) {
            $worker = $this->getReference(self::REF_WORKER.'_' . rand(self::AMOUNTOFUSERS + 1, self::AMOUNTOFUSERS + self::AMOUNTOFWORKERS));
            array_push($workers, $worker);
        }
        return $workers;
    }

    public function getDependencies()
    {
        return array(
            UserFixtures::class,
        );
    }
}
