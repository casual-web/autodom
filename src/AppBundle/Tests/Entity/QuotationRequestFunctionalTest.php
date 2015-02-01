<?php
/**
 * Created by PhpStorm.
 * User: olivier
 * Date: 31/01/15
 * Time: 18:49
 */

namespace AppBundle\Tests\Entity;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use AppBundle\DataFixtures\ORM\LoadQuotationRequestData;
use AppBundle\DataFixtures\ORM\LoadBusinessServicesData;


class QuotationRequestFunctionalTest extends WebTestCase
{

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    public function setUp()
    {
        static::$kernel = static::createKernel();
        static::$kernel->boot();
        $this->em = static::$kernel->getContainer()->get('doctrine.orm.request_manager');
        $this->dem = $this->em->getDoctrineDefaultManager();

        // add fixtures
        $fixtureLoaderBS = new LoadBusinessServicesData();
        $fixtureLoaderQR = new LoadQuotationRequestData();
        $fixtureLoaderBS->load($this->dem);
        $fixtureLoaderQR->load($this->dem);

        //add relations
        $bsr = $this->dem->getRepository('AppBundle\Entity\BusinessService');
        $businessServiceCollection = $bsr->findByRefList(array('DSP', 'VIT'));
        $quotationRequest = $this->em->loadEntity(1);
        $this->em->persistAndFlushCollectionServiceRelation(
            $quotationRequest,
            $businessServiceCollection);

    }


    public function testSearchByCategoryName()
    {

        $products = $this->em
            ->getRepository('AppBundle:QuotationRequest')
            ->findByContactOrigin('recherche sur internet');

        $this->assertCount(2, $products);
    }

    public function tearDown()
    {

        $this->truncateTables();

    }

    public function truncateTables()
    {

        $connection = $this->dem->getConnection();
        $sqlQuery = <<<EOT
                    START TRANSACTION;
                    SET FOREIGN_KEY_CHECKS=0;
                    TRUNCATE QuotationRequest;
                    TRUNCATE BusinessService;
                    TRUNCATE QuotationRequestServiceRelation;
                    SET FOREIGN_KEY_CHECKS=1;
                    COMMIT;
EOT;
        $connection->query($sqlQuery);
    }
}