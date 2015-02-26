<?php
/**
 * Created by PhpStorm.
 * User: olivier
 * Date: 31/01/15
 * Time: 18:49
 */

namespace AppBundle\Tests\Entity;

use AppBundle\Entity\QuotationRequest;
use AppBundle\DBAL\Types\QuotationRequestStatusEnumType;
use AppBundle\DBAL\Types\ContactOriginEnumType;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


class NotifierTest extends WebTestCase
{
    /**
     * @var Symfony\Component\DependencyInjection\Container;
     */
    static private $container;

    /**
     * @var AppBundle\Notification\Notifier;
     */
    static private $notifier;

    static public function setUpBeforeClass()
    {

        $kernel = static::createKernel();
        $kernel->boot();
        self::$container = $kernel->getContainer();
        self::$notifier = self::$container->get('autodom.notifier');
    }


    public function testQRBodyRendering()
    {
        $quotationRequest = new QuotationRequest();
        $quotationRequest->setVehicleModel("ABARTH 500");
        $quotationRequest->setLastName('FACCHINETTI');
        $quotationRequest->setFirstName('');
        $quotationRequest->setEmail("julien.facchinetti@free.fr");
        $quotationRequest->setPhone("0611733924");
        $quotationRequest->setAddress("39 chemin de Crillon 84330 CAROMB");
        $quotationRequest->setHasShelter(true);
        $quotationRequest->setStatus(QuotationRequestStatusEnumType::CREATED);
        $quotationRequest->setContactOrigin(ContactOriginEnumType::WORD_OF_MOUTH);
        $quotationRequest->setProblemDescription("2 coups dans la portière conducteur et peinture terne sur le capot moteur");

        $expected = new \DOMDocument;
        $expected->load('./Fixtures/qr_body_rendering.xml');
        $actual = new \DOMDocument;
        $bodyRendered = self::$notifier->renderQuotationRequestNotificationBody($quotationRequest);
        $actual->loadXML($bodyRendered);

        $this->assertEqualXMLStructure(
            $expected->firstChild,
            $actual->firstChild
        );
    }


}