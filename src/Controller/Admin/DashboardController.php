<?php

namespace App\Controller\Admin;

use App\Entity\Bouquet;
use App\Entity\Cart;
use App\Entity\CartItem;
use App\Entity\Client;
use App\Entity\Decoration;
use App\Entity\Flower;
use App\Entity\FlowerItem;
use App\Entity\Order;
use App\Entity\Package;;

use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $routeBuilder = $this->container->get(AdminUrlGenerator::class);
        $url = $routeBuilder->setController(FlowerCrudController::class)->generateUrl();

        return $this->redirect($url);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Online Flower');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToCrud('Цветы', 'fa-brands fa-pagelines', Flower::class);
        yield MenuItem::linkToCrud('Упаковки', 'fa-solid fa-gift',  Package::class);
        yield MenuItem::linkToCrud('Украшения', 'fa-solid fa-ribbon',  Decoration::class);
        yield MenuItem::linkToCrud('Заказы', 'fa-solid fa-list-check',  Order::class);
        yield MenuItem::linkToCrud('Client', 'fa-solid fa-list-check',  Client::class);
    }
}
