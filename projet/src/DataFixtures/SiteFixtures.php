<?php

namespace App\DataFixtures;

use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;
use App\Entity\Site;

class SiteFixtures extends BaseFixtures
{

    public function loadData(ObjectManager $manager)
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
            $manager->persist($site);

        }

        $manager->flush();
    }


}
