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

class EmailImporterTest extends WebTestCase
{

    /**
     * @var string
     */
    static private $kernelRootDir;
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    public function setUp()
    {
        static::$kernel = static::createKernel();
        static::$kernel->boot();
        self::$kernelRootDir = static::$kernel->getRootDir();
        $this->em = static::$kernel->getContainer()->get('doctrine.orm.entity_manager');
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
        $emailImporter->prepareFiles();
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
        $emailImporter->prepareFiles();
        $files = $emailImporter->getFiles();

        foreach ($files as $file) {

            $actual = new \DOMDocument;
            $actual->loadXML($file);

            $this->assertEqualXMLStructure(
                $expected->firstChild,
                $actual->firstChild
            );
        }
    }

    public function testEntityCreation()
    {
        $emailImporter = new EmailImporter($this->getFixturesPath('sans_lieu_intervention_AVANT_2013_08_17'));
        $entites = $emailImporter->loadEntities();
        $this->assertEquals('hibou84@hotmail.fr', $entites[0]->getEmail());

    }



    public function tearDown()
    {

    }

}
