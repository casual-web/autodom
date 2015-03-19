<?php

namespace AppBundle\Entity;

// This is the *OWNING* side from Doctrine ORM point of view :
// http://docs.doctrine-project.org/en/latest/reference/unitofwork-associations.html

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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\QuotationRequest", inversedBy="quotationRequestServiceRelations")
     * @ORM\JoinColumn(name="quotation_request_id", referencedColumnName="id",  onDelete="CASCADE")
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
     * @var string
     *
     * @ORM\Column(name="business_service_ref", type="string")
     */
    private $businessServiceRef;

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
     * Get businessServiceRef
     *
     * @return string
     */
    public function getBusinessServiceRef()
    {
        return $this->businessServiceRef;
    }

    /**
     * Set businessServiceRef
     *
     * @param string $businessServiceRef
     * @return QuotationRequestServiceRelation
     */
    public function setBusinessServiceRef($businessServiceRef)
    {
        $this->businessServiceRef = $businessServiceRef;

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
     * @param \AppBundle\Entity\QuotationRequest $quotationRequest
     * @return QuotationRequestServiceRelation
     */
    public function setQuotationRequest(\AppBundle\Entity\QuotationRequest $quotationRequest = null)
    {
        $this->quotationRequest = $quotationRequest;

        return $this;
    }


}
