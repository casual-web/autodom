<?php

namespace AppBundle\DataFixtures\ORM;

/**
 * Created by PhpStorm.
 * User: olivier
 * Date: 29/01/15
 * Time: 21:54
 */

use AppBundle\Entity\QuotationRequest;
use AppBundle\Entity\QuotationRequestServiceRelation;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadQuotationRequestData implements FixtureInterface
{

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $qr1 = new QuotationRequest();
        $qr1->setVehicleModel("ABARTH 500");
        $qr1->setLastName('FACCHINETTI');
        $qr1->setFirstName('');
        $qr1->setEmail("julien.facchinetti@free.fr");
        $qr1->setPhone("0611733924");
        $qr1->setAddress("39 chemin de Crillon 84330 CAROMB");
        $qr1->setHasShelter(true);
        $qr1->setContactOrigin('recherche sur internet');
        $qr1->setProblemDescription("2 coups dans la portière conducteur et peinture terne sur le capot moteur");

        $qrsr = new QuotationRequestServiceRelation();
        $qrsr->setBusinessServiceId(118);
        $qrsr->setQuotationRequest($qr1);

        $manager->persist($qr1);
        $manager->persist($qrsr);

        $qr2 = new QuotationRequest();
        $qr2->setVehicleModel("ABARTH 500");
        $qr2->setLastName('Brendis');
        $qr2->setFirstName('');
        $qr2->setEmail("letrefle23@yahoo.fr");
        $qr2->setPhone("0635778922");
        $qr2->setAddress("13010 marseille");
        $qr2->setHasShelter(false);
        $qr2->setContactOrigin('recherche sur internet');
        $qr2->setProblemDescription("Donner un coup de jeune pour mise en vente");
        $manager->persist($qr2);

        $manager->flush();

    }
}