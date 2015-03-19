<?php
/**
 * Created by PhpStorm.
 * User: olivier
 * Date: 17/03/15
 * Time: 12:03
 */

namespace AppBundle\Tests\EmailImporter;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use AppBundle\EmailImporter\EmailImporter;
use AppBundle\Entity\QuotationRequest;
use AppBundle\DBAL\Types\ContactOriginEnumType;
use AppBundle\Manager\QuotationRequestManager;

class EmailImporterTest extends WebTestCase
{

    /**
     * @var string
     */
    static private $kernelRootDir;
    /**
     * @var \AppBundle\Manager\QuotationRequestManager
     */
    private $em;

    public function setUp()
    {
        static::$kernel = static::createKernel();
        static::$kernel->boot();
        self::$kernelRootDir = static::$kernel->getRootDir();
        $this->em = static::$kernel->getContainer()->get('doctrine.orm.quotation_request_manager');
    }

    public function testShouldLoadSevenFiles()
    {
        $emailImporter = new EmailImporter($this->getFixturesPath('autre'));
        $finder = $emailImporter->getFinder();
        $this->assertEquals(4, $finder->files()->count());
    }

    private function getFixturesPath($subPath = '')
    {
        if (!empty($subPath)) {
            $subPath = '/' . $subPath;
        }
        return
            sprintf(
                '%s%s',
                self::$kernelRootDir . '/../src/AppBundle/Tests/EmailImporter/Fixtures',
                $subPath);
    }

    public function testShouldPrepareSevenFiles()
    {
        $emailImporter = new EmailImporter($this->getFixturesPath('sans_lieu_intervention_AVANT_2013_08_17'));
        $this->assertEquals(3, $emailImporter->getNbFiles());
    }

    public function testShouldPrepareFiles()
    {
        $this->ShouldPrepareFiles('sans_lieu_intervention_AVANT_2013_08_17');
        $this->ShouldPrepareFiles('autre');
    }

    public function ShouldPrepareFiles($inputPath)
    {

        $emailImporter = new EmailImporter($this->getFixturesPath($inputPath));
        $expected = new \DOMDocument;
        $expected->load($this->getFixturesPath($inputPath . "/expected/xml_structure.xml"));
        $XMLStrings = $emailImporter->getXMLStrings();

        foreach ($XMLStrings as $string) {

            $actual = new \DOMDocument;
            $actual->loadXML($string);

            $this->assertEqualXMLStructure(
                $expected->firstChild,
                $actual->firstChild
            );
        }
    }

    public function testEntityCreationV1()
    {
        $emailImporter = new EmailImporter($this->getFixturesPath('sans_lieu_intervention_AVANT_2013_08_17'));
        $entites = $emailImporter->loadEntities();

        // testing body content
        $this->assertEquals('hibou84@test.1234.fr', $entites[0]->getEmail());
        $this->assertEquals('ex: Audi A4 an 96', $entites[0]->getVehicleModel());
        $this->assertEquals('goupil', $entites[0]->getLastName());
        $this->assertEquals('0668608056', $entites[0]->getPhone());
        $this->assertEquals('1 place de la camargue', $entites[0]->getAddress());
        $this->assertEquals(ContactOriginEnumType::INTERNET_SEARCH, $entites[0]->getContactOrigin());
        $this->assertEquals('ex: Décrivez votre problème en quelques lignes
                    pare brise fissurer', $entites[0]->getProblemDescription());

        //testing header content
        $this->assertEquals('2013-07-16 09:22:00', $entites[0]->getCreated()->format('Y-m-d H:i:s'));

        $qrsr = $entites[0]->getQuotationRequestServiceRelations();
        $this->assertEquals('VIT', $qrsr[0]->getBusinessServiceRef());

    }

    public function testEntityCreationV2()
    {
        $emailImporter = new EmailImporter($this->getFixturesPath('autre'));
        $entities = $emailImporter->loadEntities();

        // testing body content
        $this->assertEquals('syla13@test.1234.fr', $entities[2]->getEmail());
        $this->assertEquals('mercedes c 220 coupe cdi', $entities[2]->getVehicleModel());
        $this->assertEquals('Gontal', $entities[2]->getLastName());
        $this->assertEquals('0665216414', $entities[2]->getPhone());
        $this->assertEquals(true, $entities[2]->getHasShelter());
        $this->assertEquals('21 rue des erables
                    84130 le pontet', $entities[2]->getAddress());
        $this->assertEquals(ContactOriginEnumType::OTHER, $entities[2]->getContactOrigin());
        $this->assertEquals("Bonjour, j\\'ai la peinture qui part au dessus de la plaque d\\'immatriculation et j\\'ai 2 bosses au
                    niveau de la portière a cause du vent et une vers l\\'arriere", $entities[2]->getProblemDescription());

        //testing header content
        $this->assertEquals('2015-03-05 22:38:00', $entities[2]->getCreated()->format('Y-m-d H:i:s'));

        $qrsr = $entities[2]->getQuotationREquestServiceRelations();
        $this->assertEquals(2, count($qrsr));
        $this->assertEquals('DSP', $qrsr[1]->getBusinessServiceRef());
        $this->assertEquals('CAR', $qrsr[0]->getBusinessServiceRef());

    }

    public function directoryProvider()
    {
        return array(
            array('autre', 4),
            array('sans_lieu_intervention_AVANT_2013_08_17', 3),

        );
    }

    /**
     * @dataProvider directoryProvider
     */
    public function testImport($directoryName, $recordsNb)
    {
        $emailImporter = new EmailImporter($this->getFixturesPath($directoryName));
        $entities = $emailImporter->loadEntities();
        foreach ($entities as $entity) {
            $this->em->persistAndFlush($entity);
        }
        $this->assertEquals($recordsNb, count($this->em->getRepository()->findAll()));
    }


    public function tearDown()
    {
        $is = $this->em->getRepository()->createQueryBuilder('q');
        $is->where("q.email LIKE :domain")
            ->setParameter('domain', '%test.1234%');
        $results = $is->getQuery()->execute();

        foreach ($results as $entity) {
            $this->em->remove($entity);
        }
        $this->em->flush();

    }

}
