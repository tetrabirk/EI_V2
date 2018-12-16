<?php

namespace App\DataFixtures;

use App\Entity\Admin;
use App\Entity\Worker;
use Cocur\Slugify\Slugify;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends BaseFixtures
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

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
                $admin->setActive(true);
                $admin->setEmail('admin@admin.com');
                $admin->setPassword($this->passwordEncoder->encodePassword(
                    $admin,'password'
                ));

                $this->addRefToIndex(self::REF_ADMIN,$admin,$i);
                $manager->persist($admin);

            } else {
                $worker = $user;
                $worker->setActive(true);
                if($i === 1){
                    $worker->setEmail('test@test.com');
                }else{
                    $worker->setEmail($email);
                }
                $worker->setPassword($this->passwordEncoder->encodePassword(
                    $worker,'password'
                ));
                if ($i <= (self::AMOUNT_OF_AUTHORS+1)) {
                    $worker->setActive(true);
                    $this->addRefToIndex(self::REF_AUTHOR,$worker,$i-1);
                } else {
                    $worker->setActive(false);
                }

                $this->addRefToIndex(self::REF_WORKER,$worker,$i-1);
                $manager->persist($worker);
            }
        }
    }
}


