<?php

namespace App\DataFixtures;
use App\Entity\Site;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class BaseFixtures extends Fixture
{
    const AMOUNTOFSITES = 10;

    static $Countries = ['Belgium', 'Germany', 'Luxembourg'];

    /** @var Generator */
    protected $faker;

    public function load(ObjectManager $manager)
    {




    }
}
