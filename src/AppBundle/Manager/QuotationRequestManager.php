<?php

namespace AppBundle\Manager;

use Doctrine\ORM\EntityManager;


class QuotationRequestManager extends BaseManager
{
    protected $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function loadEntity($entityId)
    {
        return $this->getRepository()
            ->findOneBy(array('id' => $entityId));
    }

    public function getRepository()
    {
        return $this->em->getRepository('AppBundle:QuotationRequest');
    }

    public function getDoctrineDefaultManager()
    {
        return $this->em;
    }

}