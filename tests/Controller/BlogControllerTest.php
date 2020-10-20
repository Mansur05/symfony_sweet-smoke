<?php


namespace App\Tests\Controller;


use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BlogControllerTest extends WebTestCase
{

    public function testDirect(): void
    {
        $client = static::createClient();
        $postRepository = static::$container->get(PostRepository::class);

        $post = $postRepository->find(1);
        $this->assertNotNull($post);

        $client->request('GET', '/blog/' . $post->getSlug());

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertStringContainsStringIgnoringCase($post->getTitle(), $client->getResponse()->getContent());
    }

    public function testFromCatalog(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        $linkToPost = $crawler
            ->filter('a:contains("READ MORE")')
            ->eq(1)
            ->link();

        $client->click($linkToPost);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

}