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


class QuotationRequestStatusEnumType extends AbstractEnumType
{

    const CREATED = 'NEW';               // new quotation request from USER
    const SCHEDULED = 'SCH';             // intervention is scheduled
    const PENDING = 'PEND';              // waiting for information
    const CHARGED = 'CHAR';
    const CASHED = 'CASH';
    const CANCELLED = 'CAN';


    /**
     * @var array Readable choices
     * @static
     */
    protected static $choices = array(

        self::CREATED => 'nouvelle',
        self::SCHEDULED => 'programmée',
        self::PENDING => 'en attente',
        self::CHARGED => 'facturé',
        self::CASHED => 'réglé',
        self::CANCELLED => 'annulé'

    );

}

