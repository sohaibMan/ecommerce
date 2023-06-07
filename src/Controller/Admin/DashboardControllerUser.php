<?php

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardControllerUser extends AbstractDashboardController
{
    #[Route('/user', name: 'app_dashboard_user')]
    public function index(): Response
    {
        // return parent::index();

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        // return $this->redirect($adminUrlGenerator->setController(UserCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        return $this->render('user/index.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('E-COMMERCE');
    }

//    public function configuUreMenuItems(): iterable
//    {
//        // yield MenuItem::linkToDashboard('User', 'fa fa-home');
//        // yield MenuItem::linkToCrud('Product', 'fa-solid fa-basket-shopping', Product::class);
//
//        // yield MenuItem::section('User');
//        // yield MenuItem::linkToCrud('All User', 'fa-solid fa-users', User::class);
//
//        yield MenuItem::section('Mon Panier');
//        yield MenuItem::linkToCrud('Mon Panier', 'fa-solid fa-users', User::class);
//    }
}
