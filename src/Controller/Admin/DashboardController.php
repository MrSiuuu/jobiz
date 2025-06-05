<?php

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Company;
use App\Entity\Job;
use App\Entity\JobCategory;
use App\Entity\JobType;
use App\Entity\JobApplication;
use App\Entity\User;

#[AdminDashboard(routePath: '/admin', routeName: 'admin')]
class DashboardController extends AbstractDashboardController
{
    public function index(): Response
    {
        // Affiche un dashboard personnalisé avec le menu EasyAdmin
        return $this->render('admin/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Jobiz');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Entreprises', 'fa fa-building', Company::class);
        yield MenuItem::linkToCrud('Offres', 'fa fa-briefcase', Job::class);
        yield MenuItem::linkToCrud('Catégories', 'fa fa-tags', JobCategory::class);
        yield MenuItem::linkToCrud('Types de contrat', 'fa fa-clock', JobType::class);
        yield MenuItem::linkToCrud('Candidatures', 'fa fa-envelope', JobApplication::class);
        yield MenuItem::linkToCrud('Utilisateurs', 'fa fa-user', User::class);
    }
}
