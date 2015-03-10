<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BusinessServiceControllerTest extends WebTestCase
{

    public function testCompleteScenario()
    {
        $UNIQUE_REF = uniqid('BUSISERV');

        // Create a new client to browse the application
        $client = static::createClient();

        // Create a new entry in the database
        $crawler = $client->request('GET', '/admin/service/');
        $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Unexpected HTTP status code for GET /admin/service/");
        $crawler = $client->click($crawler->selectLink("Créer service")->link());

        // Fill in the form and submit it
        $form1 = $crawler->selectButton('Créer')->form(array(
            "appbundle_businessservice[ref]" => $UNIQUE_REF,
            "appbundle_businessservice[description]" => 'Le FOO BUSISERV...',
            "appbundle_businessservice[name]" => 'FOO BUSISERV',
            "appbundle_businessservice[enabled]" => true,

        ));

        $client->submit($form1);
        $crawler = $client->followRedirect();

        // Check data in the show view
        $this->assertGreaterThan(0, $crawler->filter("td:contains('$UNIQUE_REF')")->count(), "Missing element td:contains('$UNIQUE_REF')");

        // Edit the entity
        $crawler = $client->click($crawler->selectLink('Editer')->last()->link());

        $form2 = $crawler->selectButton('Mettre à jour')->form(array(
            "appbundle_businessservice[ref]" => $UNIQUE_REF,
            "appbundle_businessservice[description]" => 'Le bar BUSISERV...',
            "appbundle_businessservice[name]" => 'Bar BUSISERV',
            "appbundle_businessservice[enabled]" => true,
        ));

        $client->submit($form2);
        $crawler = $client->followRedirect();

        // Check the element contains an attribute with value equals "$UNIQUE_REF"
        $this->assertGreaterThan(0, $crawler->filter("[value='Bar BUSISERV']")->count(), "Missing element [value='Bar BUSISERV']");

        // Delete the entity
        $client->submit($crawler->selectButton('Supprimer')->form());
        $crawler = $client->followRedirect();

        // Check the entity has been delete on the list
        $this->assertNotRegExp("/$UNIQUE_REF/", $client->getResponse()->getContent());
    }

}
