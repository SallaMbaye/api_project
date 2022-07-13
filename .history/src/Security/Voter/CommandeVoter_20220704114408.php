<?php

namespace App\Security\Voter;

use App\Entity\User;
use App\Entity\Commande;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class CommandeVoter extends Voter
{
   /*  public const EDIT = 'POST_EDIT';
    public const VIEW = 'POST_VIEW';

    public const COMMANDE_EDIT="commande_edit";
    public const COMMANDE_DELETE="commande_delete"; */
    // Plusieurs permissions peuvent 

    private $security = null;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }


    protected function supports(string $attribute, $subject): bool
    {

        $supportsAttribute = in_array($attribute, ['COMMANDE_ALL', 'COMMANDE_CREATE', 'COMMANDE_READ', 'COMMANDE_EDIT', 'COMMANDE_DELETE']);
        
        $supportsSubject = $subject instanceof Commande;

        return $supportsSubject && $supportsAttribute;
    
    
    }
    
    protected function voteOnAttribute(string $attribute, $commande, TokenInterface $token): bool
    {
        $user = $token->getUser();

        if (!$user instanceof UserInterface) {

            return false;
        }

        //dd($attribute);
        

        switch ($attribute){

            case 'COMMANDE_EDIT': 

                if($this->canEdit($user)){





                }
                
                break;

        
            
            case 'COMMANDE_DELETE':
                
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
}
