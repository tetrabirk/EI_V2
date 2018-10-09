<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

abstract class BaseFixtures extends Fixture
{
    const AMOUNT_OF_SITES = 10;

    static $countries = ['Belgium', 'Germany', 'Luxembourg'];

    /** @var ObjectManager */
    private $manager;
    /** @var Generator */
    protected $faker;


    abstract protected function loadData(ObjectManager $manager);

    public function load(ObjectManager $manager)
    {
        $this->manager = $manager;
        $this->faker = Factory::create('fr_BE');
        $this->loadData($manager);

    }

}
