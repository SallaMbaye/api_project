<?php

namespace App\Security\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class CommandeVoter extends Voter
{
    public const EDIT = 'POST_EDIT';
    public const VIEW = 'POST_VIEW';

    const COMMANDE_EDIT="commande_edit";
    const COMMANDE_DELETE="commande_delete";
    // Plusieurs permissions peuvent 

    protected function supports(string $attribute, $subject): bool
    {
        
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, [self::COMMANDE_EDIT, self::COMMANDE_DELETE])
            && $subject instanceof \App\Entity\Commande;
    }

    
    
    
    protected function voteOnAttribute(string $attribute, $com, TokenInterface $token): bool
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case self::EDIT:
                // logic to determine if the user can EDIT
                // return true or false
                break;
            case self::VIEW:
                // logic to determine if the user can VIEW
                // return true or false
                break;
        }

        return false;
    }
}
