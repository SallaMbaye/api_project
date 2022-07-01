<?php



namespace App\Controller;

use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Address;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class UserController extends AbstractController
{

        public function _invoke(string $subject, string $mailFrom, string $mailTo, string $template, array $parameters, ?string $path=null): void
        {
            try {
                    $email = (new TemplatedEmail())

                    ->from(new Address($mailFrom))

                    ->to(new Address($mailTo))

                    ->subject($subject)

                    ->htmlTemplate($template)

                    ->context($parameters)
                ;
    
                if ($path) {

                    $email->attachFromPath($path);
                }
    
                $this->mailer->send($email);
    
            } catch (TransportExceptionInterface $exception) {

                //$this->messageService->addError($exception->getMessage());
            }
        
        
        }
}