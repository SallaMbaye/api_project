<?php

namespace App\Security\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class CommandeVoter extends Voter
{
    public const EDIT = 'POST_EDIT';
    public const VIEW = 'POST_VIEW';

    public const COMMANDE_EDIT="commande_edit";
    public const COMMANDE_DELETE="commande_delete";
    // Plusieurs permissions peuvent 

    protected function supports(string $attribute, $subject): bool
    {
        
        
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, [self::COMMANDE_EDIT, self::COMMANDE_DELETE])
            && $subject instanceof \App\Entity\Commande;
    }

    
    
    
    protected function voteOnAttribute(string $attribute, $commande, TokenInterface $token): bool
    {
        $user = $token->getUser();

          dd($user);

        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        if($commande->getClient()===null){



        }





    
        switch ($attribute) {
            //verification Edition
            case self::COMMANDE_EDIT:
                
                break;

            //verification suppression
            case self::COMMANDE_DELETE:
                
                break;
        }

        return false;
    }

    pub
}
