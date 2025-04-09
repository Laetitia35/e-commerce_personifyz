<?php

namespace App\Controller\Client;

use App\Entity\Customization;
use App\Controller\Client\CustomizationCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\SecurityBundle\Security;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator as EasyAdminUrlGenerator;

class ClientDashboardController extends AbstractDashboardController
{
    public function __construct(private AdminUrlGenerator $adminUrlGenerator) {}

    #[Route('/client', name: 'client_dashboard')]
    public function index(): Response
    {
        return $this->render('client/dashboard.html.twig', [
            'dashboard_url' => $this->adminUrlGenerator
                ->setController(CustomizationCrudController::class)
                ->generateUrl()
        ]);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Espace Client');
    }

    public function configureMenuItems(): iterable
    {
        return [
            MenuItem::linkToDashboard('Tableau de bord', 'fa fa-home'),
            MenuItem::linkToCrud('Personnalisations', 'fa fa-paint-brush', Customization::class),
        ];
    }
}