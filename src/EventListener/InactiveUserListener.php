<?php

namespace App\EventListener;

use App\Entity\Users;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpKernel\Event\RequestEvent;

// Permet de déconnecter un compte désactivé en cours de session
// Priorité 0 : après le firewall, qui recharge l'utilisateur
#[AsEventListener(event: 'kernel.request', priority: 0)]
class InactiveUserListener
{
    public function __construct(private readonly Security $security)
    {
    }

    public function __invoke(RequestEvent $event): void
    {
        $user = $this->security->getUser();
        if ($event->isMainRequest() && $user instanceof Users && !$user->isActive()) {
            $response = $this->security->logout(false);
            if (null !== $response) {
                $event->setResponse($response);
            }
        }
    }
}