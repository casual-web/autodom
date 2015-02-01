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
        $manager->persist($qr1);

        $qr2 = new QuotationRequest();
        $qr2->setVehicleModel("Audi A6");
        $qr2->setLastName('Brendis');
        $qr2->setFirstName('');
        $qr2->setEmail("letrefle23@yahoo.fr");
        $qr2->setPhone("0635778922");
        $qr2->setAddress("13010 marseille");
        $qr2->setHasShelter(false);
        $qr2->setContactOrigin('recherche sur internet');
        $qr2->setProblemDescription("Donner un coup de jeune pour mise en vente");
        $manager->persist($qr2);

        $qr3 = new QuotationRequest();
        $qr3->setVehicleModel("mercedes classe c 220");
        $qr3->setLastName('pantani');
        $qr3->setFirstName('joe');
        $qr3->setEmail("	jo-moha84@hotmail.fr");
        $qr3->setPhone("0761594387");
        $qr3->setAddress("13010 marseille");
        $qr3->setHasShelter(false);
        $qr3->setContactOrigin('7 rue loucheur');
        $qr3->setProblemDescription("Peinture pare choc avant et arrière , Aile gauche avant et aile gauche arrière a de bosselé et a peindre fard avant a renoverr");
        $manager->persist($qr3);

        $manager->flush();

    }
}
