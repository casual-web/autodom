<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class FrontendControllerTest extends WebTestCase
{
    public function testHome()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/home');
    }

    public function testQuotationrequest()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/quotationRequest');
    }

    public function testGallery()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/gallery');
    }

    public function testQualitycharter()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/qualityCharter');
    }

    public function testPartners()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/partners');
    }

    public function testBusinessservice()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/businessService');
    }

}
