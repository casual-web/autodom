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

    public function persistAndFlushCollectionServiceRelation(QuotationRequest $quotationRequest, array $businessServices)
    {

        foreach ($businessServices as $bsEntity) {
            $this->persistOneServiceRelation($quotationRequest, $bsEntity);
        }
        $this->em->flush();
    }

    public function persistOneServiceRelation(QuotationRequest $quotationRequest, BusinessService $businessService)
    {
        $relation = new QuotationRequestServiceRelation();
        $relation->setBusinessServiceId($businessService->getId());
        $relation->setQuotationRequest($quotationRequest);
        $this->em->persist($relation);
    }

}