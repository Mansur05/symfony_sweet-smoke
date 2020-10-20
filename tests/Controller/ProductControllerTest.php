<?php


namespace App\Tests\Controller;


use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProductControllerTest extends WebTestCase
{

    public function testDirect(): void
    {
        $client = static::createClient();
        $productRepository = static::$container->get(ProductRepository::class);

        $product = $productRepository->find(1);
        $this->assertNotNull($product);

        $client->request('GET', '/product/' . $product->getSlug());

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertStringContainsStringIgnoringCase($product->getName(), $client->getResponse()->getContent());
    }

    public function testFromCatalog(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        $linkToPost = $crawler
            ->filter('a:contains("BUY")')
            ->eq(1)
            ->link();

        $client->click($linkToPost);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

}