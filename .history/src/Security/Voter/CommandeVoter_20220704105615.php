<?php

namespace App\Security\Voter;

use App\Entity\User;
use App\Entity\Commande;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

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

        if (!$user instanceof UserInterface) {

            return false;
        }






    
        switch ($attribute) {

            //verification Edition


            case self::COMMANDE_EDIT: 

                dd($this->canEdit($commande,$user));
                
                break;

            //verification suppression
            case self::COMMANDE_DELETE:
                
                break;
        }

        return false;
    }

    private function canEdit(User $user){

        return $user->getRoles[1]==="ROLE_GESTIONNAIRE";

    }

    private function canDelete(User $user){
        return $user->getRoles[1]==="ROLE_GESTIONNAIRE";

        
    }
}
