<?php
/**
 * Created by PhpStorm.
 * User: olivier
 * Date: 21/02/17
 * Time: 14:10
 */

namespace AppBundle\Tests\Entity;

use AppBundle\Entity\QuotationRequestServiceRelation;

class QuotationRequestServiceRelationCollection extends \PHPUnit_Framework_TestCase
{

    public function testGetReferences()
    {

        $QRS1 = new QuotationRequestServiceRelation();
        $QRS2 = new QuotationRequestServiceRelation();
        $data = [$QRS1->setBusinessServiceRef('DSP'), $QRS2->setBusinessServiceRef('CAR')];
        $references = new \AppBundle\Entity\QuotationRequestServiceRelationCollection($data);

        $this->assertEquals(['DSP', 'CAR'], $references->getBusinessServiceReferences());
    }

    public function testNoGetReferences()
    {

        $references = new \AppBundle\Entity\QuotationRequestServiceRelationCollection([]);
        $this->assertEquals([], $references->getBusinessServiceReferences());
    }
}
