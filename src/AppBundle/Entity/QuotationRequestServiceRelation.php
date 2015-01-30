<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * QuotationRequestServiceRelation
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class QuotationRequestServiceRelation
{
    /**
     * @ORM\ManyToOne(targetEntity="QuotationRequest", inversedBy="$quotation_request_service_relation")
     * @ORM\JoinColumn(name="quotation_request_id", referencedColumnName="id")
     */
    protected $quotationRequest;
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @var integer
     *
     * @ORM\Column(name="quotation_request_id", type="integer")
     */
    private $quotationRequestId;
    /**
     * @var integer
     *
     * @ORM\Column(name="business_service_id", type="integer")
     */
    private $businessServiceId;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get quotationRequestId
     *
     * @return integer
     */
    public function getQuotationRequestId()
    {
        return $this->quotationRequestId;
    }

    /**
     * Set quotationRequestId
     *
     * @param integer $quotationRequestId
     * @return QuotationRequestServiceRelation
     */
    public function setQuotationRequestId($quotationRequestId)
    {
        $this->quotationRequestId = $quotationRequestId;

        return $this;
    }

    /**
     * Get businessServiceId
     *
     * @return integer
     */
    public function getBusinessServiceId()
    {
        return $this->businessServiceId;
    }

    /**
     * Set businessServiceId
     *
     * @param integer $businessServiceId
     * @return QuotationServiceMap
     */
    public function setBusinessServiceId($businessServiceId)
    {
        $this->businessServiceId = $businessServiceId;

        return $this;
    }

    /**
     * Get  quotation request
     *
     * @return \AppBundle\Entity\QuotationRequest
     */
    public function getQuotationRequest()
    {
        return $this->quotationRequest;
    }

    /**
     * Set quotation request
     *
     * @param \AppBundle\Entity\QuotationRequest $quotation_request
     * @return QuotationRequestServiceRelation
     */
    public function setQuotationRequest(\AppBundle\Entity\QuotationRequest $quotationRequest = null)
    {
        $this->quotationRequest = $quotationRequest;

        return $this;
    }
}
