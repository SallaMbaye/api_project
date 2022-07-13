<?php

namespace App\Security\Voter;

use App\Entity\User;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

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
                
                if($this->canCreate($user)){
    
                    return true; 
    
                }
                break;
            case 'ZONE_ALL':
                
                break;
                        
        }

        return false;
    }
    private function canEdit(User $user){

        return in_array("ROLE_GESTIONNAIRE",$user->getRoles());


    }

    private function canDelete(User $user){

        return in_array("ROLE_GESTIONNAIRE",$user->getRoles());
        
    }

    private function canList(User $user){

        return in_array("ROLE_VISITEUR",$user->getRoles());


    }
    private function canCreate(User $user){

        return in_array("ROLE_GESTIONNAIRE",$user->getRoles());


    }
}
