<?php

namespace AppBundle\Manager;

use AppBundle\Entity\QuotationRequest;
use Doctrine\ORM\EntityManager;
use \Doctrine\Common\Collections\ArrayCollection;

class QuotationRequestManager extends BaseManager
{
    protected $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function getRepository()
    {
        return $this->em->getRepository('AppBundle:QuotationRequest');
    }

    public function getDoctrineDefaultManager()
    {
        return $this->em;
    }

    public function persistAndFlush(QuotationRequest $entity)
    {

        $qrsr_collection = $entity->getQuotationRequestServiceRelations()->toArray();
        $this->persistAndFlushWithRelations($entity, $qrsr_collection);

    }

    public function persistAndFlushWithRelations(QuotationRequest $entity, $qrsr_collection)
    {

        $entity->getQuotationRequestServiceRelations()->clear();
        $this->em->persist($entity);
        $this->em->flush();

        if (null !== $qrsr_collection) {
            foreach ($qrsr_collection as $qrsr) {
                $qrsr->setQuotationRequest($entity);
                $this->em->persist($qrsr);
            }
            $this->em->flush();
        }
    }
}