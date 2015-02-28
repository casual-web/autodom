<?php

namespace AppBundle\DataFixtures\ORM;

/**
 * Created by PhpStorm.
 * User: olivier
 * Date: 27/01/15
 * Time: 21:54
 */

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\ImageSite;

class LoadImageSiteData implements FixtureInterface
{

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {

        $isDSP = new ImageSite();
        $isDSP->setVehicleModel('audi A3');
        $isDSP->setBusinessServiceRef('DSP');
        $isDSP->setLocation("Marseille (13)");
        $isDSP->setDamageType("Coup de genoux, aile avant");
        $isDSP->setCarouselOrder(1);
        $manager->persist($isDSP);

        $isDSP2 = new ImageSite();
        $isDSP2->setVehicleModel('Renault Clio2');
        $isDSP2->setBusinessServiceRef('DSP');
        $isDSP2->setLocation("Vaucluse (84)");
        $isDSP2->setDamageType("poque");
        $isDSP2->setCarouselOrder(2);
        $manager->persist($isDSP2);

        $isDSP3 = new ImageSite();
        $isDSP3->setVehicleModel('Citroën 2CV');
        $isDSP3->setBusinessServiceRef('DSP');
        $isDSP3->setLocation("Avignon (84)");
        $isDSP3->setDamageType("grêle");
        $isDSP3->setCarouselOrder(3);
        $manager->persist($isDSP3);

        $isVIT = new ImageSite();
        $isVIT->setVehicleModel('Mercedes SLK');
        $isVIT->setBusinessServiceRef('VIT');
        $isVIT->setLocation("Vitrolle (13)");
        $isVIT->setDamageType("impact cailloux");
        $isVIT->setCarouselOrder(1);
        $manager->persist($isVIT);

        $manager->flush();

    }
}

