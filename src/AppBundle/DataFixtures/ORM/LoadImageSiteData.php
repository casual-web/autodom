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
use Symfony\Component\HttpFoundation\File\UploadedFile;

class LoadImageSiteData implements FixtureInterface
{


    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {

        $uFile = $this->createUploadFiles('img1');
        $isDSP = new ImageSite();
        $isDSP->setFile($uFile);
        $isDSP->setVehicleModel('audi A3  (TEST)');
        $isDSP->setBusinessServiceRef('DSP');
        $isDSP->setLocation("Marseille (13)");
        $isDSP->setDamageType("Coup de genoux, aile avant");
        $isDSP->setCarouselOrder(4);
        $manager->persist($isDSP);

        $uFile2 = $this->createUploadFiles('img2');
        $isDSP2 = new ImageSite();
        $isDSP2->setFile($uFile2);
        $isDSP2->setVehicleModel('Renault Clio2 (TEST)');
        $isDSP2->setBusinessServiceRef('DSP');
        $isDSP2->setLocation("Vaucluse (84)");
        $isDSP2->setDamageType("poque");
        $isDSP2->setCarouselOrder(2);
        $manager->persist($isDSP2);

        $uFile3 = $this->createUploadFiles('img3');
        $isDSP3 = new ImageSite();
        $isDSP3->setFile($uFile3);
        $isDSP3->setVehicleModel('Citroën 2CV (TEST)');
        $isDSP3->setBusinessServiceRef('DSP');
        $isDSP3->setLocation("Avignon (84)");
        $isDSP3->setDamageType("grêle");
        $isDSP3->setCarouselOrder(3);
        $isDSP3->setVisible(true);
        $manager->persist($isDSP3);

        $uFile4 = $this->createUploadFiles('img4');
        $isVIT = new ImageSite();
        $isVIT->setFile($uFile4);
        $isVIT->setVehicleModel('Mercedes SLK2 (TEST)');
        $isVIT->setBusinessServiceRef('VIT');
        $isVIT->setLocation("Vitrolle (13)");
        $isVIT->setDamageType("impact cailloux");
        $isVIT->setCarouselOrder(3);
        $isVIT->setVisible(true);
        $manager->persist($isVIT);

        $manager->flush();

    }

    /**
     * Files are deleted by move function of UploadedFile
     * (=> this is the same with use of File)
     * @return UploadedFile
     */
    public function createUploadFiles($fileName)
    {
        copy(__DIR__ . "/files/original/$fileName.jpg", __DIR__ . "/files/tmp/$fileName.jpg");
        return new UploadedFile(__DIR__ . "/files/tmp/$fileName.jpg", "$fileName.jpg", null, null, null, true);
    }
}

