<?php

namespace AppBundle\Manager;

use AppBundle\Entity\QuotationRequest;
use AppBundle\Entity\QuotationRequestServiceRelation;
use AppBundle\Entity\BusinessService;
use Doctrine\ORM\EntityManager;


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

    public function persistAndFlushServiceRelations(QuotationRequest $quotationRequest, array $businessServices)
    {

        foreach ($businessServices as $bsEntity) {

            $relation = $this->createServiceRelation($quotationRequest, $bsEntity);
            $this->em->persist($relation);
        }
        $this->em->flush();
    }

    public function createServiceRelation(QuotationRequest $quotationRequest, BusinessService $businessService)
    {

        $relation = new QuotationRequestServiceRelation();
        $relation->setBusinessServiceRef($businessService->getRef());
        $relation->setQuotationRequest($quotationRequest);
        return $relation;
    }

}