<?php
/**
 * Created by PhpStorm.
 * User: olivier
 * Date: 15/02/15
 * Time: 21:01
 */

namespace CW\UserBundle\DataFixtures\ORM;


use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use CW\UserBundle\Entity\User;

class LoadUser implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        // Les noms d'utilisateurs à créer
        $listNames = array('Alexandre', 'Marine', 'Anna');

        foreach ($listNames as $name) {
            // On crée l'utilisateur
            $user = new User;

            // Le nom d'utilisateur et le mot de passe sont identiques
            $user->setUsername($name);
            $user->setPassword($name);
            $user->setEmail("$name@email.com");

            // On ne se sert pas du sel pour l'instant
            $user->setSalt('');
            // On définit uniquement le role ROLE_USER qui est le role de base
            $user->setRoles(array('ROLE_USER'));

            // On le persiste
            $manager->persist($user);
        }

        // On déclenche l'enregistrement
        $manager->flush();
    }
}