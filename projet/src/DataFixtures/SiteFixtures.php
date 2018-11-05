<?php

namespace App\DataFixtures;

use App\Entity\Task;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;
use App\Entity\Site;

class SiteFixtures extends BaseFixtures
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

            $this->genTasks($manager,$site,$i);

            $this->addRefToIndex(self::REF_SITE,$site,$i);


            $manager->persist($site);
        }
    }

    public function genTasks(ObjectManager $manager,Site $site, $i)
    {
        $amountLevel1 = rand(self::MIN_AMOUNT_L1_TASK, self::MAX_AMOUNT_L1_TASK);

        for ($j = 1; $j <= $amountLevel1; $j++) {
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

}
