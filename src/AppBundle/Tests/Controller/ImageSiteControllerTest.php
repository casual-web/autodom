<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ImageSiteControllerTest extends WebTestCase
{

    public function testCompleteScenario()
    {
        // Create a new client to browse the application
        $client = static::createClient();

        // Create a new entry in the database
        $crawler = $client->request('GET', '/admin/photos/');
        $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Unexpected HTTP status code for GET /admin/photos/");
        $crawler = $client->click($crawler->selectLink('Ajouter photo')->link());

        // Fill in the form and submit it
        $form = $crawler->selectButton('Ajouter')->form(array(
            'appbundle_imagesite[vehicleModel]' => 'twingo',
            'appbundle_imagesite[businessServiceRef]' => 'DSP',
            'appbundle_imagesite[location]' => 'Lyon 7',
            'appbundle_imagesite[file]' => '/home/olivier/Dev/autodom/src/AppBundle/Tests/Controller/Fixtures/contact.jpg',
            'appbundle_imagesite[damageType]' => 'bosse capot',
            'appbundle_imagesite[carouselOrder]' => '7'
        ));

        $client->submit($form);
        $crawler = $client->followRedirect();

        // Check data in the show view
        $this->assertGreaterThan(0, $crawler->filter('td:contains("twingo")')->count(), 'Missing element td:contains("twingo")');

        // Edit the entity
        $crawler = $client->click($crawler->selectLink('Editer')->link());

        $form = $crawler->selectButton('Mettre à jour')->form(array(
            'appbundle_imagesite[vehicleModel]' => 'twingo',
            'appbundle_imagesite[businessServiceRef]' => 'OPT',
            'appbundle_imagesite[location]' => 'Lyon 7',
            'appbundle_imagesite[damageType]' => 'bosse capot',
            'appbundle_imagesite[carouselOrder]' => '1984'
        ));

        $client->submit($form);
        $crawler = $client->followRedirect();

        // Check the element contains an attribute with value equals "Foo"
        $this->assertGreaterThan(0, $crawler->filter('[value="1984"]')->count(), 'Missing element [value="1984"]');

        // Delete the entity
        $client->submit($crawler->selectButton('Supprimer')->form());

        // Check the entity has been delete on the list
        $this->assertNotRegExp('/1984/', $client->getResponse()->getContent());
    }


}
