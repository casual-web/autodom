<?php
/**
 * Created by PhpStorm.
 * User: olivier
 * Date: 31/01/15
 * Time: 16:02
 */

namespace AppBundle\Manager;


abstract class BaseManager
{

    public function persist($entity)
    {
        $this->em->persist($entity);
    }

    public function flush()
    {
        $this->em->flush();
    }

    public function remove($entity)
    {
        $this->em->remove($entity);
    }
}