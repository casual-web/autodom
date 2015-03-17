<?php
/**
 * Created by PhpStorm.
 * User: olivier
 * Date: 31/01/15
 * Time: 18:49
 */

namespace AppBundle\Tests\Entity;

use AppBundle\DBAL\Types\ContactOriginEnumType;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use AppBundle\DataFixtures\ORM\LoadQuotationRequestData;
use AppBundle\DataFixtures\ORM\LoadBusinessServicesData;


class BusinessServiceFunctionalTest extends WebTestCase
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

    public function tearDown()
    {

        $this->unLoadFixtures();

    }

    public function testFindByRefList()
    {
        $bsr = $this->em->getRepository('AppBundle\Entity\BusinessService');
        $businessServiceCollection = $bsr->findByRefList(array('DSP', 'VIT'));
        $this->assertEquals(2, count($businessServiceCollection));
    }

    public function testGetChoices()
    {

        $bsr = $this->em->getRepository('AppBundle\Entity\BusinessService');

        $choices = $bsr->getChoices(false);
        $output = [
            'DSP' => 'Débosselage sans peinture',
            'OPT' => 'Rénovation optiques',
            'CAR' => 'Rénovation carrosserie',
            'VIT' => 'Remplacement vitrage (désactivé)'
        ];
        $this->assertEquals($output, $choices);

        $choices = $bsr->getChoices();
        $output = [
            'DSP' => 'Débosselage sans peinture',
            'OPT' => 'Rénovation optiques',
            'CAR' => 'Rénovation carrosserie'
        ];
        $this->assertEquals($output, $choices);
    }
}