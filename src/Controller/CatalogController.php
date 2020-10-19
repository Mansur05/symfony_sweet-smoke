<?php

namespace App\Controller;

use App\Repository\PostRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CatalogController extends AbstractController
{
    /**
     * @Route("/", name="catalog")
     */
    public function index(ProductRepository $productRepository, PostRepository $postRepository)
    {
        $products = $productRepository->findLatest();
        $posts = $postRepository->findLatest();

        return $this->render('catalog/catalog.html.twig', [
            'products' => $products,
            'posts' => $posts
        ]);
    }
}
