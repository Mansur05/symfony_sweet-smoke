<?php

namespace App\Controller;

use App\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    /**
     * @Route("/blog/{slug}", name="blog")
     */
    public function index(Post $post)
    {
        return $this->render('blog/post.html.twig', [
            'post' => $post,
        ]);
    }
}
