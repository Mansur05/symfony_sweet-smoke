<?php


namespace App\Tests\Controller;


use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CatalogControllerTest extends WebTestCase
{

    public function testIndex(): void
    {
        $client = static::CreateClient();
        $client->request('GET', '/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $this->assertStringContainsString('Latest Blog', $client->getResponse()->getContent());
        $this->assertStringContainsString('Popular Arrivals', $client->getResponse()->getContent());
    }

    public function testAdmin(): void
    {
        $client = static::createClient();
        $userRepository = static::$container->get(UserRepository::class);

        $client->request('GET', '/admin');

        $this->assertResponseRedirects('/login');
        $this->assertEquals(302, $client->getResponse()->getStatusCode());

        $adminUser = $userRepository->findOneBy(['username' => 'admin']);
        $client->loginUser($adminUser);

        $client->request('GET', '/admin');

        $this->assertEquals(302, $client->getResponse()->getStatusCode());
    }

}