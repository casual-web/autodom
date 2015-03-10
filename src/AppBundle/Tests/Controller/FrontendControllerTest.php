<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use AppBundle\DBAL\Types\ContactOriginEnumType;
use AppBundle\DataFixtures\ORM\LoadBusinessServicesData;

class FrontendControllerTest extends WebTestCase
{
    /**
     * @var stringr
     */
    private $kernelRootDir;

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    public function setUp()
    {

        static::$kernel = static::createKernel();
        static::$kernel->boot();
        $this->kernelRootDir = static::$kernel->getContainer()->getParameter('kernel.root_dir');
        $this->em = static::$kernel->getContainer()->get('doctrine.orm.entity_manager');
        $fixtureLoaderBS = new LoadBusinessServicesData();
        $fixtureLoaderBS->load($this->em);
        $this->em->clear();
    }


    public function tearDown()
    {

        $connection = $this->em->getConnection();
        $sqlQuery = <<<EOT
                    START TRANSACTION;
                    SET FOREIGN_KEY_CHECKS=0;
                    TRUNCATE BusinessService;
                    SET FOREIGN_KEY_CHECKS=1;
                    COMMIT;
EOT;
        $connection->query($sqlQuery);

    }


    public function testHome()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/home');
    }

    public function testQuotationrequest()
    {
        $client = static::createClient();

        // Create a new entry in the database
        $crawler = $client->request('GET', '/demande-devis');
        $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Unexpected HTTP status code for GET /demande-devis");

        // Fill in the form and submit it
        $form1 = $crawler->selectButton('Envoyer ma demande')->form(array(
            'appbundle_frontquotationrequest[quotationRequestServiceRelations][1]' => 'OPT',
            'appbundle_frontquotationrequest[quotationRequestServiceRelations][2]' => 'CAR',
            'appbundle_frontquotationrequest[baseqr][vehicleModel]' => 'Renault Clio',
            'appbundle_frontquotationrequest[baseqr][firstName]' => 'customer f name',
            'appbundle_frontquotationrequest[baseqr][lastName]' => 'customer l name',
            'appbundle_frontquotationrequest[baseqr][email]' => 'customer@gmail.com',
            'appbundle_frontquotationrequest[baseqr][phone]' => '0611733924',
            'appbundle_frontquotationrequest[baseqr][address]' => '3 rue du château',
            'appbundle_frontquotationrequest[baseqr][hasShelter]' => true,
            'appbundle_frontquotationrequest[baseqr][contactOrigin]' => ContactOriginEnumType::FLYERS,
            'appbundle_frontquotationrequest[baseqr][problemDescription]' => 'I got a customer problem',
        ));

        $client->submit($form1);
        $crawler = $client->request('GET', '/admin/devis/');

        // Check data in the show view
        $this->assertGreaterThan(0, $crawler->filter('td:contains("customer@gmail.com")')->count(), 'Missing element td:contains("customer@gmail.com")');

        // simply delete entity
        $crawler = $client->click($crawler->selectLink('Editer')->last()->link());
        $client->submit($crawler->selectButton('Supprimer')->form());

        // Check the entity has been delete on the list
        $this->assertNotRegExp('/customer@gmail.com/', $client->getResponse()->getContent());

    }

    public function testGallery()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/gallery');
    }

    public function testQualitycharter()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/qualityCharter');
    }

    public function testPartners()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/partners');
    }

    public function testBusinessservice()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/businessService');
    }

    public function testDSP()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/debosselage-sans-peinture');
        $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Unexpected HTTP status code for GET /debosselage-sans-peinture");

    }

}
