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
                    TRUNCATE image_site;
                    SET FOREIGN_KEY_CHECKS=1;
                    COMMIT;
EOT;
        $connection->query($sqlQuery);
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

    public function testSelectImagesByCategory()
    {
        $bsr = $this->em->getRepository('AppBundle\Entity\ImageSite');
        $entities = $bsr->findByBusinessServiceRef(array('DSP'));
        $this->assertEquals(3, count($entities));
    }

}