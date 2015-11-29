<?php
/**
 * Created by PhpStorm.
 * User: olivier
 * Date: 14/02/15
 * Time: 13:44
 */

namespace AppBundle\DBAL\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Fresh\DoctrineEnumBundle\DBAL\Types\AbstractEnumType;


class ContactOriginEnumType extends AbstractEnumType
{

    const OTHER = 'OT';
    const INTERNET_SEARCH = 'IS';
    const SITE_LINK = 'SL';
    const YELLOW_PAGES = 'YP';
    const WORD_OF_MOUTH = 'WM';
    const CARDS = 'CD';
    const FLYERS = 'FL';


    /**
     * @var array Readable choices
     * @static
     */
    protected static $choices = array(

        self::OTHER => 'autre',
        self::INTERNET_SEARCH => 'recherche sur internet',
        self::SITE_LINK => 'lien depuis un autre site',
        self::YELLOW_PAGES => 'pages jaunes',
        self::WORD_OF_MOUTH => 'bouche à oreilles',
        self::CARDS => 'cartes de visite',
        self::FLYERS => 'flyers'
    );


}

