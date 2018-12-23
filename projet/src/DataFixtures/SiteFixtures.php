<?php

namespace App\DataFixtures;

use App\Entity\Participation;
use App\Entity\Person;
use App\Entity\Task;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;
use App\Entity\Site;

class SiteFixtures extends BaseFixtures implements DependentFixtureInterface
{

    public function loadData(ObjectManager $manager)
    {
        $this->genSites($manager);

        $manager->flush();
    }

    public function genSites(ObjectManager $manager)
    {
        for ($i = 0; $i < self::AMOUNT_OF_SITES; $i++) {
            $site = new Site();

            $site->setShortName(strtoupper($this->faker->lexify('???')));
            $site->setName($this->faker->sentence(4));
            $site->setAddress($this->faker->address);
            $site->setCountry(self::$countries[array_rand(self::$countries)]);

            $site->setLatitude($this->faker->latitude(50.195540, 50.70272));
            $site->setLongitude($this->faker->longitude(4.241172, 6.086875));
            $site->setActive(true);
            $site->setFinished(false);
            $this->genTasks($manager,$site,$i);
            $this->genParticipations($manager,$site,$i);

            $this->addRefToIndex(self::REF_SITE,$site,$i);

            $manager->persist($site);
        }
    }

    public function genTasks(ObjectManager $manager,Site $site, $i)
    {
        $amountLevel1 = rand(self::MIN_AMOUNT_L1_TASK, self::MAX_AMOUNT_L1_TASK);

        for ($j = 1; $j <= $amountLevel1; $j++)
        {
            $amountLevel2 = rand(self::MIN_AMOUNT_L2_TASK, self::MAX_AMOUNT_L2_TASK);
            for ($k = 0; $k < $amountLevel2; $k++) {
                $task = new Task();

                if ($k === 0) {
                    $task->setCode($j);
                } else {
                    $task->setCode($j . '.' . $k);
                }

                $task->setName($this->faker->sentence(8));
                $task->setDescription($this->faker->text(200));
                $task->setSite($site);

                $this->addRefToIndex(self::REF_TASK,$task,$i,$j . '_' . $k);
                $manager->persist($task);
            }
        }
    }
    public function genParticipations(ObjectManager $manager, Site $site, $i)
    {
        $amountParticipant = rand(self::MIN_AMOUNT_OF_PARTICIPANT,self::MAX_AMOUNT_OF_PARTICIPANT);

        $personRefs = self::randNumberArray(0,self::MAX_AMOUNT_OF_PARTICIPANT-1,$amountParticipant);

        foreach($personRefs as $personRef)
        {
            $participation = new Participation();
            /** @var $person Person */
            $person=$this->getReference(self::REF_PERSON.'_'.$personRef);
            $participation->setPerson($person);
            $participation->setRole($this->faker->randomElement(self::$personRoles));
            $participation->setSite($site);
            self::addRefToIndex(self::REF_PARTICIPATION,$participation,$i,$personRef);
            $manager->persist($participation);

            $site->addParticipation($participation);
        }
    }


    public function getDependencies()
    {
        return array(
            PersonFixtures::class,
        );
    }

}
