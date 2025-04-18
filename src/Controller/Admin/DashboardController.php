<?php

namespace App\Controller\Admin;

use App\Entity\Color;
use App\Entity\File;
use App\Entity\MainCategory;
use App\Entity\Option;
use App\Entity\OptionValue;
use App\Entity\Product;
use App\Entity\Technique;
use App\Entity\User;
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
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        return $this->redirect($adminUrlGenerator->setController(UserCrudController::class)->generateUrl());

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        // return $this->redirect($adminUrlGenerator->setController(OneOfYourCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Personnifyz');
    }

    public function configureMenuItems(): iterable
    {
        if ($this->isGranted('ROLE_ADMIN')) {
            yield MenuItem::linkToCrud('Produits', 'fa fa-box', Product::class);
        }
    
        if ($this->isGranted('ROLE_CLIENT')) {
            yield MenuItem::linkToCrud('Mes produits', 'fa fa-paint-brush', Product::class);
        }
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Utilisateurs', 'fas fa-list', User::class);
        yield MenuItem::linkToCrud('Categories', 'fas fa-list', MainCategory::class);
        yield MenuItem::linkToCrud('Produits', 'fas fa-list', Product::class);
        yield MenuItem::linkToCrud('Options', 'fas fa-list', Option::class);
        yield MenuItem::linkToCrud('Valeurs des options', 'fas fa-list', OptionValue::class);
        yield MenuItem::linkToCrud('Techniques', 'fas fa-list', Technique::class);
        yield MenuItem::linkToCrud('Fichiers', 'fas fa-list', File::class);
        yield MenuItem::linkToCrud('Couleurs', 'fas fa-list', Color::class);
    }
}
