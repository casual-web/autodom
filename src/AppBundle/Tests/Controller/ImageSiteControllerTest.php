<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


class ImageSiteControllerTest extends WebTestCase
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
        $this->unLoadFixtures();
        $this->loadFixtures();
        $this->em->clear();
    }

    public function unLoadFixtures()
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

    public function loadFixtures()
    {

        $fixtureLoaderBS = new LoadBusinessServicesData();
        $fixtureLoaderBS->load($this->em);

    }

    public function testCompleteScenario()
    {
        // Create a new client to browse the application
        $client = static::createClient();

        // Create a new entry in the database
        $crawler = $client->request('GET', '/admin/photos/');
        $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Unexpected HTTP status code for GET /admin/photos/");
        $crawler = $client->click($crawler->selectLink('Ajouter photo')->link());

        // Fill in the form and submit it
        $form = $crawler->selectButton('Ajouter')->form(array(
            'appbundle_imagesite[vehicleModel]' => 'twingo',
            'appbundle_imagesite[businessServiceRef]' => 'DSP',
            'appbundle_imagesite[location]' => 'Lyon 7',
            'appbundle_imagesite[location]' => 'Lyon 7',
            'appbundle_imagesite[file]' => $this->kernelRootDir . '/../src/AppBundle/Tests/Controller/Fixtures/contact.jpg',
            'appbundle_imagesite[damageType]' => 'bosse capot',
            'appbundle_imagesite[carouselOrder]' => '7'
        ));

        $client->submit($form);
        $crawler = $client->followRedirect();

        // Check data in the show view
        $this->assertGreaterThan(0, $crawler->filter('td:contains("twingo")')->count(), 'Missing element td:contains("twingo")');

        // Edit the entity
        $crawler = $client->click($crawler->selectLink('Editer')->link());

        $form = $crawler->selectButton('Mettre à jour')->form(array(
            'appbundle_imagesite[vehicleModel]' => 'twingo',
            'appbundle_imagesite[businessServiceRef]' => 'OPT',
            'appbundle_imagesite[location]' => 'Lyon 7',
            'appbundle_imagesite[damageType]' => 'bosse capot',
            'appbundle_imagesite[carouselOrder]' => '1984'
        ));

        $client->submit($form);
        $crawler = $client->followRedirect();

        // Check the element contains an attribute with value equals "Foo"
        $this->assertGreaterThan(0, $crawler->filter('[value="1984"]')->count(), 'Missing element [value="1984"]');

        // Delete the entity
        $client->submit($crawler->selectButton('Supprimer')->form());

        // Check the entity has been delete on the list
        $this->assertNotRegExp('/1984/', $client->getResponse()->getContent());
    }

    public function tearDown()
    {

        $this->unLoadFixtures();

    }


}
