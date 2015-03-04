<?php
/**
 * Created by PhpStorm.
 * User: olivier
 * Date: 31/01/15
 * Time: 18:49
 */

namespace AppBundle\Tests\Entity;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use AppBundle\DataFixtures\ORM\LoadImageSiteData;

class ImageSiteFunctionalTest extends WebTestCase
{

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    public function setUp()
    {

        static::$kernel = static::createKernel();
        static::$kernel->boot();
        $this->em = static::$kernel->getContainer()->get('doctrine.orm.entity_manager');
        $this->loadFixtures();
        $this->em->clear();
    }

    public function loadFixtures()
    {

        $fixtureLoaderBS = new LoadImageSiteData();
        $fixtureLoaderBS->load($this->em);

    }

    public function tearDown()
    {

        $this->unLoadFixtures();

    }

    public function unLoadFixtures()
    {
        $is = $this->em->getREpository('AppBundle:ImageSite')->createQueryBuilder('i');
        $is->where("i.businessServiceRef LIKE :ref")
            ->setParameter('ref', 'FIXTURE%')
            ->delete();

        $is->getQuery()->execute();
    }

    public function testSelectImagesByCategory()
    {
        $bsr = $this->em->getRepository('AppBundle\Entity\ImageSite');
        $entities = $bsr->findByBusinessServiceRef(array('FIXTURE1'));
        $this->assertEquals(3, count($entities));
    }

    public function testFindVisible()
    {
        $bsr = $this->em->getRepository('AppBundle\Entity\ImageSite');
        $entities = $bsr->findVisibleByService('FIXTURE1');
        $this->assertEquals(1, count($entities));
    }

    public function testOrdering()
    {
        $bsr = $this->em->getRepository('AppBundle\Entity\ImageSite');
        $entities = $bsr->findAll();
        $this->assertEquals('FIXTURE1', $entities[2]->getBusinessServiceRef());
        $this->assertEquals(4, $entities[2]->getCarouselOrder());
        $this->assertEquals('FIXTURE2', $entities[3]->getBusinessServiceRef());
        $this->assertEquals(3, $entities[3]->getCarouselOrder());

    }


}