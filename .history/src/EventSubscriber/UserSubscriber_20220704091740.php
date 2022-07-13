<?php

namespace App\EventSubscriber;


use App\Entity\Menu;
use App\Entity\User;
use App\Entity\Burger;
use App\Entity\Commande;
use Doctrine\ORM\Events;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;


class UserSubscriber implements EventSubscriberInterface
{
    
    private ?TokenInterface $token;

    
    
    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->token = $tokenStorage->getToken();


    }

    /* public function sendMail(ViewEvent $event): void
    {
        $user = $event->getControllerResult();

        $method = $event->getRequest()->getMethod();

        if (!$user instanceof User || Request::METHOD_POST !== $method) 
        {
            return;
        }

        $message = (new Email())
            
            ->from('system@example.com')

            ->to('contact@les-tilleuls.coop')

            ->subject('A new user has been added')

            ->text(sprintf('The user #%d has been added.', $user->getId()));

        $this->mailer->send($message);
    }
 */
    public static function getSubscribedEvents(): array
    {
        return [Events::prePersist];
    }
    public function getUser()
    { 
        if (null === $token = $this->token) {
            
            return null;
        }
        
        if (!is_object($user = $token->getUser())) {
        
            return null;
        }
        
        return $user;
    }
    
    public function prePersist(LifecycleEventArgs $args)
    {
        if ($args->getObject() instanceof Commande) {

            $args->getObject()->setGestionnaire($this->getUser());

        }

        if ($args->getObject() instanceof Burger) {
        
            $args->getObject()->setGestionnaire($this->getUser());

        }

        if ($args->getObject() instanceof Menu) {
            
            $args->getObject()->setGestionnaire($this->getUser());
        }

    }}
    
