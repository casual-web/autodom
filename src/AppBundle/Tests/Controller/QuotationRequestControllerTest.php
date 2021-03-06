<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use AppBundle\DBAL\Types\QuotationRequestStatusEnumType;
use AppBundle\DBAL\Types\ContactOriginEnumType;


class QuotationRequestControllerTest extends WebTestCase
{
    public function testCompleteScenario()
    {
        // Create a new client to browse the application
        $client = static::createClient();

        // Create a new entry in the database
        $crawler = $client->request('GET', '/admin/devis/');
        $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Unexpected HTTP status code for GET /admin/devis/");
        $crawler = $client->click($crawler->selectLink('Créer devis')->link());

        // Fill in the form and submit it
        $form1 = $crawler->selectButton('Créer')->form(array(
            'appbundle_quotationrequest[baseqr][vehicleModel]' => 'Renault Clio',
            'appbundle_quotationrequest[baseqr][firstName]' => 'toto',
            'appbundle_quotationrequest[baseqr][lastName]' => 'likou',
            'appbundle_quotationrequest[baseqr][email]' => 't.likou@gmail.com',
            'appbundle_quotationrequest[baseqr][phone]' => '0611733924',
            'appbundle_quotationrequest[baseqr][address]' => '3 rue du château',
            'appbundle_quotationrequest[baseqr][hasShelter]' => true,
            'appbundle_quotationrequest[status]' => QuotationRequestStatusEnumType::CREATED,
            'appbundle_quotationrequest[baseqr][contactOrigin]' => ContactOriginEnumType::FLYERS,
            'appbundle_quotationrequest[baseqr][problemDescription]' => 'I got a problem',

        ));

        $client->submit($form1);
        $crawler = $client->followRedirect();

        // Check data in the show view
        $this->assertGreaterThan(0, $crawler->filter('td:contains("0611733924")')->count(), 'Missing element td:contains("0611733924")');

        // Edit the entity
        $crawler = $client->click($crawler->selectLink('Editer')->last()->link());

        $form2 = $crawler->selectButton('Mettre à jour')->form(array(
            'appbundle_quotationrequest[baseqr][vehicleModel]' => 'Clio2',
            'appbundle_quotationrequest[baseqr][firstName]' => 'toto',
            'appbundle_quotationrequest[baseqr][lastName]' => 'likou',
            'appbundle_quotationrequest[baseqr][email]' => 't.likou@gmail.com',
            'appbundle_quotationrequest[baseqr][phone]' => '0611733924',
            'appbundle_quotationrequest[baseqr][address]' => '3 rue du château',
            'appbundle_quotationrequest[baseqr][hasShelter]' => true,
            'appbundle_quotationrequest[status]' => QuotationRequestStatusEnumType::CREATED,
            'appbundle_quotationrequest[baseqr][contactOrigin]' => ContactOriginEnumType::FLYERS,
            'appbundle_quotationrequest[baseqr][problemDescription]' => 'I got a problem'
        ));

        $client->submit($form2);
        $crawler = $client->followRedirect();

        // Check the element contains an attribute with value equals "Clio2"
        $this->assertGreaterThan(0, $crawler->filter('[value="Clio2"]')->count(), 'Missing element [value="Clio2"]');

        // Delete the entity
        $client->submit($crawler->selectButton('Supprimer')->form());

        // Check the entity has been delete on the list
        $this->assertNotRegExp('/Renault Clio2/', $client->getResponse()->getContent());
    }
}
