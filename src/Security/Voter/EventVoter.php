<?php

namespace App\Security\Voter;

use App\Entity\Events;
use App\Entity\Users;
use App\Repository\TeamMemberRepository;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

// Voter : l'admin peut tout modifier, le coach uniquement les équipes qu'il gère
class EventVoter extends Voter
{
    public const EDIT = 'EVENT_EDIT';

    public function __construct(
        private readonly AccessDecisionManagerInterface $access,
        private readonly TeamMemberRepository $teamMembers,
    ) {
    }

    protected function supports(string $attribute, mixed $subject): bool
    {
        return self::EDIT === $attribute && $subject instanceof Events;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        if (!$user instanceof Users) {
            return false;
        }

        if ($this->access->decide($token, ['ROLE_ADMIN'])) {
            return true;
        }

        $team = $subject->getTeamId();
        if (null === $team || !$this->access->decide($token, ['ROLE_COACH'])) {
            return false;
        }

        return $this->teamMembers->count(['user_id' => $user, 'team_id' => $team]) > 0;
    }
}