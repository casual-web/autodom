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
        $userAdmin = new BusinessService();
        $userAdmin->setName('Débosselage sans peinture');
        $userAdmin->setRef('DSP');
        $userAdmin->setDescription("Le débosselage sans peinture est un procédé qui permet de résorber des bosses sur la carrosserie des véhicules automobiles.");
        $manager->persist($userAdmin);
        $manager->flush();

        $userAdmin = new BusinessService();
        $userAdmin->setName('Rénovation optiques');
        $userAdmin->setRef('OPT');
        $userAdmin->setDescription("Sur la base d'un ponçage du phare opacifié, deux processus sont proposés afin de retrouver l'éclat d'origine d'un phare terni : le Polish et le Revernis.");
        $manager->persist($userAdmin);
        $manager->flush();

        $userAdmin = new BusinessService();
        $userAdmin->setName("Rénovation carrosserie");
        $userAdmin->setRef('CAR');
        $userAdmin->setDescription("Sur la base d'un ponçage du phare opacifié, deux processus sont proposés afin de retrouver l'éclat d'origine d'un phare terni");
        $manager->persist($userAdmin);
        $manager->flush();

        $userAdmin = new BusinessService();
        $userAdmin->setName('Remplacement vitrage');
        $userAdmin->setRef('VIT');
        $userAdmin->setDescription("Remplacement de tout vitrage sur véhicule léger dans le respect des normes en vigueur de la communauté européenne. Si vous êtes assuré 'bris de glace' : nous vérifions ensemble que votre assurance prend bien le sinistre en charge.");
        $manager->persist($userAdmin);
        $manager->flush();

    }
}

