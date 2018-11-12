<?php

namespace App\DataFixtures;

use App\Entity\Person;
use Cocur\Slugify\Slugify;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class PersonFixtures extends BaseFixtures
{

    public function loadData(ObjectManager $manager)
    {
        $this->genPersons($manager);

        $manager->flush();
    }

    public function genPersons(ObjectManager $manager)
    {
        $this->slugify = new Slugify();
        for($i=0;$i<self::AMOUNT_OF_PERSONS;$i++){
            $person = new Person();
            $person->setName($this->faker->lastName);
            $person->setFirstName($this->faker->firstName);
            $person->setCompany($this->faker->company);
            $person->setContactEmail(
                $this->slugify->slugify($person->getFirstName()).'.'.
                $this->slugify->slugify($person->getName()).'@'.
                $this->slugify->slugify($person->getCompany()).'.com'
            );
            $person->setPhone1($this->faker->phoneNumber);
            $person->setPhone2($this->faker->optional(0.5)->phoneNumber);

            $this->addRefToIndex(self::REF_PERSON,$person,$i);
            $manager->persist($person);
        }
    }
}
