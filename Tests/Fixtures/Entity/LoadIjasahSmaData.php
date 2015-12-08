<?php

namespace Ais\IjasahSmaBundle\Tests\Fixtures\Entity;

use Ais\IjasahSmaBundle\Entity\IjasahSma;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;


class LoadIjasahSmaData implements FixtureInterface
{
    static public $ijasah_smas = array();

    public function load(ObjectManager $manager)
    {
        $ijasah_sma = new IjasahSma();
        $ijasah_sma->setTitle('title');
        $ijasah_sma->setBody('body');

        $manager->persist($ijasah_sma);
        $manager->flush();

        self::$ijasah_smas[] = $ijasah_sma;
    }
}
