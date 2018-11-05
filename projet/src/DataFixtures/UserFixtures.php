<?php

namespace App\DataFixtures;

use App\Entity\Admin;
use App\Entity\Worker;
use Cocur\Slugify\Slugify;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class UserFixtures extends BaseFixtures
{

    public function loadData(ObjectManager $manager)
    {
        $this->slugify = new Slugify();

        $this->genUsers($manager);

        $manager->flush();
    }


    public function genUsers(ObjectManager $manager)
    {

        $this->slugify = new Slugify();
        for($i=0;$i<(self::AMOUNT_OF_WORKERS+1);$i++) {

            if ($i === 0) {
                $user = new Admin();
            } else {
                $user = new Worker();
            }

            $user->setName($this->faker->lastName);
            $user->setFirstName($this->faker->firstName);
            $user->setCompany(self::COMPANY_NAME);
            $email =
                $this->slugify->slugify($user->getFirstName()) . '.' .
                $this->slugify->slugify($user->getName()) . '@' .
                $this->slugify->slugify($user->getCompany()) . '.be';
            $user->setContactEmail($email);
            $user->setPhone1($this->faker->phoneNumber);
            $user->setPhone2($this->faker->optional(0.5)->phoneNumber);

            if ($i === 0) {
                $admin = $user;
                $admin->setType('employee');
                $admin->setActive(true);
                $admin->setEmail('admin@admin.com');
                $admin->setPassword('password'); //TODO encrypt passwords

                $this->addRefToIndex(self::REF_ADMIN,$admin,$i);
                $manager->persist($admin);

            } else {
                $worker = $user;
                $worker->setType('worker');
                $worker->setActive(true);
                $worker->setEmail($email);
                $worker->setPassword('password'); //TODO encrypt passwords

                if ($i <= (self::AMOUNT_OF_AUTHORS+1)) {
                    $worker->setActive(true);
                } else {
                    $worker->setActive(false);
                }

                $this->addRefToIndex(self::REF_WORKER,$worker,$i);
                $manager->persist($worker);
            }
        }
    }
}


