<?php

namespace App\Controller\Admin;

use App\Entity\Post;
use App\Entity\Product;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\CrudUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        $routeBuilder = $this->get(CrudUrlGenerator::class)->build();

        return $this->redirect($routeBuilder->setController(ProductCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Sweet Smoke');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::section('Admin Panel');
        yield MenuItem::linkToCrud('Products', 'fas fa-shopping-bag', Product::class);
        yield MenuItem::linkToCrud('Posts', 'fas fa-sticky-note', Post::class);
        yield MenuItem::section('You');
        yield MenuItem::linkToLogout('Logout', 'fa fa-sign-out');
    }
}
