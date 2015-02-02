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
use AppBundle\Entity\BusinessService;

class LoadBusinessServicesData implements FixtureInterface {

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {

        $manager->clear();

        $bsDSP = new BusinessService();
        $bsDSP->setName('Débosselage sans peinture');
        $bsDSP->setRef('DSP');
        $bsDSP->setDescription("Le débosselage sans peinture est un procédé qui permet de résorber des bosses sur la carrosserie des véhicules automobiles.");
        $manager->persist($bsDSP);


        $bsOPT = new BusinessService();
        $bsOPT->setName('Rénovation optiques');
        $bsOPT->setRef('OPT');
        $bsOPT->setDescription("Sur la base d'un ponçage du phare opacifié, deux processus sont proposés afin de retrouver l'éclat d'origine d'un phare terni : le Polish et le Revernis.");
        $manager->persist($bsOPT);


        $bsCAR = new BusinessService();
        $bsCAR->setName("Rénovation carrosserie");
        $bsCAR->setRef('CAR');
        $bsCAR->setDescription("Sur la base d'un ponçage du phare opacifié, deux processus sont proposés afin de retrouver l'éclat d'origine d'un phare terni");
        $manager->persist($bsCAR);


        $bsVIT = new BusinessService();
        $bsVIT->setName('Remplacement vitrage');
        $bsVIT->setRef('VIT');
        $bsVIT->setDescription("Remplacement de tout vitrage sur véhicule léger dans le respect des normes en vigueur de la communauté européenne. Si vous êtes assuré 'bris de glace' : nous vérifions ensemble que votre assurance prend bien le sinistre en charge.");
        $manager->persist($bsVIT);

        $manager->flush();

    }
}

