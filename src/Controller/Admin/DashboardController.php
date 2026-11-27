<?php

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;

#[AdminDashboard(routePath: '/admin', routeName: 'admin')]
class DashboardController extends AbstractDashboardController
{
    public function index(): Response
    {
        return parent::index();

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // return $this->redirectToRoute('admin_user_index');

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirectToRoute('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('FutsalBezons');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        // yield MenuItem::linkTo(SomeCrudController::class, 'The Label', 'fas fa-list');
        yield MenuItem::linkto(UsersCrudController::class, 'Utilisateurs', 'fas fa-user');
        yield MenuItem::linkto(MembershipCrudController::class, 'Adhésions', 'fa fa-id-card-o');
        yield MenuItem::linkto(PaymentCrudController::class, 'Paiement', 'fa fa-money');
        yield MenuItem::linkto(TeamCrudController::class, 'Equipes', 'fas fa-users');
        yield MenuItem::linkto(TeamMemberCrudController::class, 'Joueurs', 'fa fa-futbol-o');
        yield MenuItem::linkto(MembershipCrudController::class, 'Adhésions', 'fa fa-id-card-o');
        yield MenuItem::linkto(SeasonCrudController::class, 'Saison', 'fas fa-trophy');
        yield MenuItem::linkto(EventsCrudController::class, 'Calendrier', 'fa fa-calendar-o');       
    
    }
}
