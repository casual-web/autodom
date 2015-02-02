<?php


/**
 *
 * @ORM\OneToMany(targetEntity="AppBundle\Entity\QuotationRequestServiceRelation", mappedBy="quotationRequest", cascade={"remove", "persist"})
 *
 */
protected
$quotationRequestServiceRelations;

?>