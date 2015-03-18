<?php
/**
 * Created by PhpStorm.
 * User: olivier
 * Date: 17/03/15
 * Time: 12:12
 */

namespace AppBundle\EmailImporter;

use AppBundle\Entity\QuotationRequestServiceRelation;
use Symfony\Component\Finder\Finder;
use AppBundle\Entity\QuotationRequest;
use AppBundle\DBAL\Types\ContactOriginEnumType;

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
     * @var array
     */
    static private $contactOriginMap = [
        'Autre' => ContactOriginEnumType::OTHER,
        'Recherche sur Internet' => ContactOriginEnumType::INTERNET_SEARCH,
        'Lien depuis un autre site' => ContactOriginEnumType::SITE_LINK,
        'Pages jaunes' => ContactOriginEnumType::YELLOW_PAGES,
        'Bouche à oreille' => ContactOriginEnumType::WORD_OF_MOUTH,
        'Cartes de visite' => ContactOriginEnumType::CARDS,
        'flyers' => ContactOriginEnumType::FLYERS
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

    /**
     * @param QuotationRequest
     */
    private $quotationRequestCollection;


    function __construct($directory)
    {
        $this->directory = $directory;
        $this->finder = new Finder();
        $this->finder->in($this->directory)->exclude('expected');
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

    /**
     * @return QuotationRequest
     */
    public function getQuotationRequestCollection()
    {
        return $this->quotationRequestCollection;
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

        $this->quotationRequestCollection = array();

        foreach ($this->files as $XMLString) {
            $qr = $this->createQuotationRequest($XMLString);
            $this->quotationRequestCollection[] = $qr;
        }

        return $this->quotationRequestCollection;
    }

    /**
     * @param $XMLString string
     * @return QuotationRequest
     */
    public function createQuotationRequest($XMLString)
    {

        $email = $this->extractEmailData($XMLString);
        $qr = new QuotationRequest;

        // email body extraction
        $qr->setEmail(trim($email['email']));
        $qr->setVehicleModel(trim($email['marque']));
        $qr->setProblemDescription(trim($email['description']));
        $qr->setLastName(trim($email['nom']));
        $qr->setPhone(trim($email['telephone']));
        $qr->setAddress(trim($email['adresse']));
        $qr->setContactOrigin(self::$contactOriginMap[trim($email['comment vous nous avez trouvé'])]);

        if (isset($email['lieu_intervention'])) {
            $qr->setHasShelter((strpos($email['lieu_intervention'], 'OUI') !== false) ? true : false);
        }
        // email header extraction
        $dateTime = \DateTime::createFromFormat('d/m/Y H:i', $email['Date :']);
        $qr->setCreated($dateTime->format('Y-m-d H:i:s'));

        if ($qrsr = $this->createQuotationRequestRelation($email, 'VITRA', 'VIT')) {
            $qr->addQuotationRequestServiceRelation($qrsr);
        }

        if ($qrsr = $this->createQuotationRequestRelation($email, 'OPTIC', 'OPT')) {
            $qr->addQuotationRequestServiceRelation($qrsr);
        }

        if ($qrsr = $this->createQuotationRequestRelation($email, 'CARROS', 'CAR')) {
            $qr->addQuotationRequestServiceRelation($qrsr);
        }

        if ($qrsr = $this->createQuotationRequestRelation($email, 'DEBOS', 'DSP')) {
            $qr->addQuotationRequestServiceRelation($qrsr);
        }

        return $qr;

    }

    public function extractEmailData($XMLString)
    {

        $extractedEmailData = array();
        $sXE = simplexml_load_string($XMLString);
        $sXEFiltered = $sXE->xpath("/html/body/div/table");

        // extract body
        foreach ($sXEFiltered as $item) {
            if ($item->children()->getName() === 'td') {
                $tds = $item->children();
                $index = null;
                foreach ($tds as $item) {
                    if (null !== $index) {
                        $extractedEmailData[$index] = strval($item);
                        $index = null;
                    } else {
                        if ($item->b) {
                            $index = trim(strval($item->b));
                            $extractedEmailData[$index] = null;

                        }
                    }
                }
            }
        }

        // extract header
        $sXEFiltered = $sXE->xpath("/html/body/table[@class='header-part1']");
        foreach ($sXEFiltered as $item) {
            if ($item->children()->getName() === 'td') {
                $tds = $item->children();
                foreach ($tds as $item) {
                    $extractedEmailData[trim(strval($item->div))] = trim(strval($item));
                }
            }

        }
        return $extractedEmailData;

    }

    /**
     * @param $email string
     * @param $oldRef string
     * @param $newRef strinf
     * @return QuotationRequestServiceRelation
     */
    public function createQuotationRequestRelation($email, $oldRef, $newRef)
    {
        $qrsr = null;
        if (strpos($email['Sujet :'], $oldRef) !== false) {
            $qrsr = new QuotationRequestServiceRelation();
            $qrsr->setBusinessServiceRef($newRef);
        }

        return $qrsr;
    }


}