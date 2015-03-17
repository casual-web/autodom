<?php
/**
 * Created by PhpStorm.
 * User: olivier
 * Date: 17/03/15
 * Time: 12:12
 */

namespace AppBundle\EmailImporter;

use Symfony\Component\Finder\Finder;
use AppBundle\Entity\QuotationRequest;

class EmailImporter
{

    static private $stringsToRemove = [
        "<contact",
        "border=0 cellspacing=0 cellpadding=0",
        '<link rel="important stylesheet" href="">',
        '<br>',
        "<tr>",
        "</tr>",
        "<h1>DEMANDE DE DEVIS sur Autodom.biz !!<h1/>",
        "</table></div>",
        "<td><b>codepromo </b></td>",
        "<td> 0</td>",


    ];
    /**
     * @var string
     */
    private $directory;
    /**
     * @var array
     */
    private $files;
    /**
     * @var Symfony\Component\Finder\Finder
     */
    private $finder;

    function __construct($directory)
    {
        $this->directory = $directory;
        $this->finder = new Finder();
        $this->finder->in($this->directory)->exclude('expected');
        $this->files = array();
    }

    /**
     * @return mixed
     */
    public function getDirectory()
    {
        return $this->directory;
    }

    /**
     * @param mixed $directory
     */
    public function setDirectory($directory)
    {
        $this->directory = $directory;
    }

    /**
     * @return Symfony\Component\Finder\Finder
     */
    public function getFinder()
    {
        return $this->finder;
    }

    /**
     * @return array
     */
    public function getFiles()
    {
        return $this->files;
    }

    public function getNbFiles()
    {

        return count($this->files);
    }

    /**
     * convert XML to quotation request
     */
    public function loadEntities()
    {

        $this->prepareFiles();
        $results = array();

        foreach ($this->files as $XMLString) {
            $results[] = $this->createEntity($XMLString);
        }

        return $results;
    }

    /**
     * fix XML format issues
     */
    public function prepareFiles()
    {

        foreach ($this->finder as $file) {
            $this->files[] = $this->toXMLString($file->getContents());
        }
    }

    /**
     * clean HTML file
     * @param string $HTMLString
     * @return string
     */
    public function toXMLString($HTMLString)
    {
        $cleanContent = str_replace(self::$stringsToRemove, "", $HTMLString);
        $cleanContent = preg_replace(
            '/<\/html>\s?<\/table><\/div>/i',
            "</html>",
            $cleanContent);
        return $cleanContent;
    }

    public function createEntity($XMLString)
    {

        $emailBody = $this->extractEmailBody($XMLString);


        var_dump($emailBody);

        $qr = new QuotationRequest;
        $qr->setEmail(trim($emailBody['email']));

        return $qr;

    }

    public function extractEmailBody($XMLString)
    {

        $extractedEmailBody = array();
        $sXE = simplexml_load_string($XMLString);
        $sXEFiltered = $sXE->xpath("/html/body/div/table");

        foreach ($sXEFiltered as $item) {
            if ($item->children()->getName() === 'td') {
                $tds = $item->children();
                $index = null;
                foreach ($tds as $item) {

                    if (null !== $index) {
                        $extractedEmailBody[$index] = strval($item);
                        $index = null;
                    } else {
                        if ($item->b) {
                            $index = trim(strval($item->b));
                            $extractedEmailBody[$index] = null;

                        }
                    }
                }
            }

        }

        return $extractedEmailBody;

    }


}