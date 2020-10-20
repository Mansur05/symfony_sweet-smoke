<?php


namespace App\Tests\Controller;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AdminControllerTest extends WebTestCase
{

    public function testIndex(): void
    {
        $client = static::createClient();

        $client->request('GET', '/admin');

        $this->assertEquals(302, $client->getResponse()->getStatusCode());
        $this->assertResponseRedirects('/login');

        $client->followRedirect();

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}