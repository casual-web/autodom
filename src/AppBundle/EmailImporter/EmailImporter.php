<?php
/**
 * Created by PhpStorm.
 * User: olivier
 * Date: 17/03/15
 * Time: 12:12
 */

namespace AppBundle\EmailImporter;

use Symfony\Component\Finder\Finder;


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
     * fix XML format issues
     */
    public function prepareFiles()
    {

        foreach ($this->finder as $file) {
            $fileContent = $file->getContents();
            // apply replacements
            $cleanContent = str_replace(self::$stringsToRemove, "", $fileContent);
            $cleanContent = preg_replace(
                '/<\/html>\s?<\/table><\/div>/i',
                "</html>",
                $cleanContent);

            $this->files[] = $cleanContent;
        }
    }


}