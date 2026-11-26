<?php

namespace App\Controller;

use App\Entity\Users;
use App\Repository\UsersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin/users')]
#[IsGranted('ROLE_ADMIN')]
class AdminUserController extends AbstractController
{
    #[Route('', name: 'app_admin_users', methods: ['GET'])]
    public function index(UsersRepository $repository): Response
    {
        return $this->render('admin/users.html.twig', [
            'users' => $repository->findBy(['isActive' => false], ['createdAt' => 'ASC']),
        ]);
    }

    #[Route('/{id}/activate', name: 'app_admin_user_activate', methods: ['POST'])]
    public function activate(Users $user, Request $request, EntityManagerInterface $em): Response
    {
        $token = $request->getPayload()->getString('_token');
        if (!$this->isCsrfTokenValid('activate'.$user->getId(), $token)) {
            throw $this->createAccessDeniedException('Jeton CSRF invalide.');
        }

        $user->setIsActive(true)->setUpdatedAt(new \DateTimeImmutable());
        $em->flush();
        $this->addFlash('success', 'Compte activé.');

        return $this->redirectToRoute('app_admin_users');
    }
}