<?php
/**
 * Created by PhpStorm.
 * User: olivier
 * Date: 24/02/15
 * Time: 23:02
 */

namespace AppBundle\Tests\Form\DataTransformer;

use AppBundle\Form\DataTransformer\CategoryToBusinessService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CategoryToBusinessServiceTest extends KernelTestCase
{

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    public function setUp()
    {

        static::$kernel = static::createKernel();
        static::$kernel->boot();
        $this->em = static::$kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }


    public function testtransform()
    {

        $df = new CategoryToBusinessService($this->em);
        $qrsrList = $df->reverseTransform(array('DSP', 'VIT'));
        $this->assertEquals(2, count($qrsrList));
        $this->assertEquals('DSP', $qrsrList[0]->getBusinessServiceRef());
        $this->assertNull($df->reverseTransform(null));
    }

    /**
     * @expectedException Symfony\Component\Form\Exception\TransformationFailedException;
     */
    public function testTransformParameterIsNotAnArray()
    {

        $df = new CategoryToBusinessService($this->em);
        $df->reverseTransform(0);
    }
}
