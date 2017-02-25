<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

class QuotationRequestServiceRelationCollection extends ArrayCollection
{
    public function __construct(array $elements)
    {
        parent::__construct($elements);
    }

    public function getBusinessServiceReferences()
    {
        $iterator = $this->getIterator();
        $iterator->rewind();
        $references=[];
        while ($iterator->valid()) {
            $references[$iterator->key()]= $iterator->current()->getBusinessServiceRef();
            $iterator->next();
        }

        return $references;
    }
}