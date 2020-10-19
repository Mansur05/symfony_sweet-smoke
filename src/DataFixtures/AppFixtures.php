<?php

namespace App\DataFixtures;

use App\Entity\Post;
use App\Entity\Product;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Mmo\Faker\PicsumProvider;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

class AppFixtures extends Fixture
{
    private $faker;
    private $slugger;
    private $parameterBag;
    private $passwordEncoder;

    public function __construct(SluggerInterface $slugger, ParameterBagInterface $parameterBag, UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->faker = Factory::create();
        $this->faker->addProvider(new PicsumProvider($this->faker));

        $this->slugger = $slugger;

        $this->parameterBag = $parameterBag;

        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $this->loadProducts($manager);
        $this->loadPosts($manager);
        $this->loadUser($manager);
    }

    public function loadProducts(ObjectManager $manager)
    {
        for ($i = 0; $i < 5; $i++) {
            $product = new Product();
            $product->setName($this->faker->sentence(5));
            $product->setDescription($this->faker->text(400));
            $product->setPrice($this->faker->numberBetween(9000, 17000));
            $product->setArrivedAt($this->faker->dateTime());
            $product->setUpdatedAt($this->faker->dateTime());
            $product->setSlug($this->slugger->slug($product->getName()));
            $product->setThumbnail($product->getSlug() . '.jpg');

            $photo = $this->faker->picsum(null, 250, 250, true);
            file_put_contents($this->parameterBag->get('kernel.project_dir') . '/public/src/products/' . $product->getThumbnail(), file_get_contents($photo));

            $manager->persist($product);
        }

        $manager->flush();
    }

    public function loadPosts(ObjectManager $manager)
    {
        for ($i = 0; $i < 9; $i++) {
            $post = new Post();
            $post->setTitle($this->faker->sentence(7));
            $post->setSummary($this->faker->text(250));
            $post->setContent($this->faker->text(500));
            $post->setPublishedAt($this->faker->dateTime());
            $post->setUpdatedAt($this->faker->dateTime());
            $post->setSlug($this->slugger->slug($post->getTitle()));

            $post->setThumbnail($post->getSlug() . '.jpg');

            $photo = $this->faker->picsum(null, 250, 250, true);
            file_put_contents($this->parameterBag->get('kernel.project_dir') . '/public/src/posts/' . $post->getThumbnail(), file_get_contents($photo));

            $manager->persist($post);
        }

        $manager->flush();
    }

    public function loadUser(ObjectManager $manager)
    {
        $user = new User();
        $user->setUsername('admin');
        $user->setPassword($this->passwordEncoder->encodePassword($user, 'admin'));
        $user->setRoles(['ROLE_ADMIN']);

        $manager->persist($user);
        $manager->flush();
    }
}
