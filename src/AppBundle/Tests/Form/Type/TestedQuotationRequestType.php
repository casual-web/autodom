<?php
/**
 * Created by PhpStorm.
 * User: olivier
 * Date: 21/02/15
 * Time: 18:13
 */

namespace AppBundle\Tests\Form\Type;

use AppBundle\Form\QuotationRequestType;
use Symfony\Component\Form\Test\TypeTestCase;
use AppBundle\Entity\QuotationRequest;
use AppBundle\DBAL\Types\ContactOriginEnumType;
use AppBundle\DBAL\Types\QuotationRequestStatusEnumType;

class TestedQuotationRequestType extends TypeTestCase
{

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    public function testSubmitValidData()
    {

        $formData = [
            'vehicleModel' => 'AUDI A4',
            'problemDescription' => 'I have a pb !',
            'hasShelter' => true,
            'firstName' => 'toto',
            'lastName' => 'likou',
            'email' => 'toto@gmail.com',
            'phone' => '0123456789',
            'address' => '1th downing streee',
            'contactOrigin' => ContactOriginEnumType::OTHER,
            'status' => QuotationRequestStatusEnumType::CREATED,
        ];

        $bsrChoices = [
            'DSP' => 'Débosselage sans peinture',
            'VIT' => 'Remplacement vitrage',
            'CAROS' => 'Polissage carrosserie'
        ];

        $type = new QuotationRequestType($bsrChoices);
        $form = $this->factory->create($type);

        $object = new QuotationRequest();
        $object->fromArray($formData);

        // submit the data to the form directly
        $form->submit($formData);

        $this->assertTrue($form->isSynchronized());
        $this->assertEquals($object, $form->getData());

        $view = $form->createView();
        $children = $view->children;

        foreach (array_keys($formData) as $key) {
            $this->assertArrayHasKey($key, $children);
        }
    }
}

