<?php

namespace App\Security\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class ZoneVoter extends Voter
{
    public const EDIT = 'POST_EDIT';
    public const VIEW = 'POST_VIEW';

    protected function supports(string $attribute, $subject): bool
    {
        return in_array($attribute, ['ZONE_CREATE', 'ZONE_EDIT','ZONE_ALL'])
            && $subject instanceof \App\Entity\Zone;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        if (!$user instanceof UserInterface) {
            return false;
        }

        switch ($attribute) {
            case 'ZONE_EDIT':
                break;
            case 'ZONE_CREATE':
                break;
            case 'ZONE_ALL':
                
                break;
                        
        }

        return false;
    }
}
