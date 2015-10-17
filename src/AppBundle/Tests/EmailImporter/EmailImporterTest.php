<?php
/**
 * Created by PhpStorm.
 * User: olivier
 * Date: 17/03/15
 * Time: 12:03
 */

namespace AppBundle\Tests\EmailImporter;

use AppBundle\DBAL\Types\ContactOriginEnumType;
use AppBundle\EmailImporter\EmailImporter;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class EmailImporterTest extends WebTestCase
{

    /**
     * @var string
     */
    protected static $kernelRootDir;
    /**
     * @var \AppBundle\Manager\QuotationRequestManager
     */
    protected $em;

    protected static $kernel;

    public function setUp()
    {
        self::$kernel = self::createKernel();
        self::$kernel->boot();
        self::$kernelRootDir = static::$kernel->getRootDir();
        $this->em = self::$kernel->getContainer()->get('doctrine.orm.quotation_request_manager');
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
                $subPath
            );
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
        $entityTested = $entites["20130716-Demande de devis _ VITRA-26.html"];

        // testing body content
        $this->assertEquals('hibou84@test.1234.fr', $entityTested->getEmail());
        $this->assertEquals('ex: Audi A4 an 96', $entityTested->getVehicleModel());
        $this->assertEquals('goupil', $entityTested->getLastName());
        $this->assertEquals('0668608056', $entityTested->getPhone());
        $this->assertEquals('1 place de la camargue', $entityTested->getAddress());
        $this->assertEquals(ContactOriginEnumType::INTERNET_SEARCH, $entityTested->getContactOrigin());
        $this->assertEquals('ex: Décrivez votre problème en quelques lignes
                    pare brise fissurer', $entityTested->getProblemDescription());

        //testing header content
        $this->assertEquals('2013-07-16 09:22:00', $entityTested->getCreated()->format('Y-m-d H:i:s'));

        $qrsr = $entityTested->getQuotationRequestServiceRelations();
        $this->assertEquals('VIT', $qrsr[0]->getBusinessServiceRef());

    }

    public function testEntityCreationV2()
    {
        $emailImporter = new EmailImporter($this->getFixturesPath('autre'));
        $entities = $emailImporter->loadEntities();
        $entityTested = $entities["20150305-Demande de devis _ DEBOS + CARROS-114.html"];

        // testing body content
        $this->assertEquals('syla13@test.1234.fr', $entityTested->getEmail());
        $this->assertEquals('mercedes c 220 coupe cdi', $entityTested->getVehicleModel());
        $this->assertEquals('Gontal', $entityTested->getLastName());
        $this->assertEquals('0665216414', $entityTested->getPhone());
        $this->assertEquals(true, $entityTested->getHasShelter());
        $this->assertEquals('21 rue des erables
                    84130 le pontet', $entityTested->getAddress());
        $this->assertEquals(ContactOriginEnumType::OTHER, $entityTested->getContactOrigin());
        $this->assertEquals(
            "Bonjour, j\\'ai la peinture qui part au dessus de la plaque d\\'immatriculation et j\\'ai 2 bosses au
                    niveau de la portière a cause du vent et une vers l\\'arriere",
            $entityTested->getProblemDescription()
        );

        //testing header content
        $this->assertEquals('2015-03-05 22:38:00', $entityTested->getCreated()->format('Y-m-d H:i:s'));

        $qrsr = $entityTested->getQuotationREquestServiceRelations();
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
