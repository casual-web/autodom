<?php
/**
 * Created by PhpStorm.
 * User: olivier
 * Date: 21/02/15
 * Time: 18:13
 */

namespace AppBundle\Tests\Form\Type;

use AppBundle\Form\BusinessServiceType;
use Symfony\Component\Form\Test\TypeTestCase;
use AppBundle\Entity\BusinessService;

class TestedBusinessServiceType extends TypeTestCase
{

    public function testSubmitValidData()
    {
        $formData = array(
            'ref' => 'DSP',
            'description' => 'Le débosselage sans peinture...',
            'name' => 'Débosselage sans peinture',
            'enabled' => true
        );

        $type = new BusinessServiceType();
        $form = $this->factory->create($type);

        $object = new BusinessService();
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

