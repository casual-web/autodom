<?php
/**
 * Created by PhpStorm.
 * User: olivier
 * Date: 31/01/15
 * Time: 18:49
 */

namespace AppBundle\Tests\Entity;

use AppBundle\DataFixtures\ORM\LoadBusinessServicesData;
use AppBundle\DataFixtures\ORM\LoadQuotationRequestData;
use AppBundle\DBAL\Types\ContactOriginEnumType;
use AppBundle\Entity\QuotationRequestServiceRelation;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


class QuotationRequestFunctionalTest extends WebTestCase
{

    /**
     * @var \AppBundle\Manager\QuotationRequestManager;
     */
    private $quotation_em;

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $default_em;

    public function setUp()
    {

        static::$kernel = static::createKernel();
        static::$kernel->boot();
        $this->quotation_em = static::$kernel->getContainer()->get('doctrine.orm.quotation_request_manager');
        $this->default_em = $this->quotation_em->getDoctrineDefaultManager();
        $this->unLoadFixtures();
        $this->loadFixtures();
        $this->default_em->clear(); // DO NOT REMOVE "clear" : need to have test successful
    }

    public function unLoadFixtures()
    {

        $connection = $this->default_em->getConnection();
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

    public function loadFixtures()
    {

        // load existing fixtures
        $fixtureLoaderBS = new LoadBusinessServicesData();
        $fixtureLoaderQR = new LoadQuotationRequestData();
        $fixtureLoaderBS->load($this->default_em);
        $fixtureLoaderQR->load($this->default_em);

        // add relations
        $qr_repository = $this->quotation_em->getRepository();
        $qr = $qr_repository->find(1);
        $qrsr1 = new QuotationRequestServiceRelation();
        $qrsr1->setBusinessServiceRef('DSP');
        $qr->addQuotationRequestServiceRelation($qrsr1);
        $qrsr2 = new QuotationRequestServiceRelation();
        $qrsr2->setBusinessServiceRef('OPT');
        $qr->addQuotationRequestServiceRelation($qrsr2);
        $this->quotation_em->persistAndFlush($qr);

    }

    public function tearDown()
    {
        $this->unLoadFixtures();

    }

    public function testSearchByContactOrigin()
    {

        $qr = $this->quotation_em
            ->getRepository()
            ->findByContactOrigin(ContactOriginEnumType::INTERNET_SEARCH);

        $this->assertCount(2, $qr);
    }


    public function testRelations()
    {

        $repository = $this->default_em->getRepository('AppBundle:QuotationRequest');
        $quotationRequest = $repository->find(1);
        $qrRelations = $quotationRequest->getQuotationRequestServiceRelations();
        $this->assertCount(2, $qrRelations);
        $this->assertEquals('DSP', $qrRelations[0]->getBusinessServiceRef());

    }

    public function testFindDashboardMetrics()
    {

        $repository = $this->default_em->getRepository('AppBundle:QuotationRequest');
        $metrics = $repository->findDashboardMetrics();

        $this->assertEquals(
            array(
                0 => array
                (
                    'nb' => 2,
                    'status' => 'NEW',
                ),
                1 => array
                (
                    'nb' => 1,
                    'status' => 'SCH',
                )),
            $metrics);

    }



}