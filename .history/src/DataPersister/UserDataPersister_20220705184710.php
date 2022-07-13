<?php

namespace App\DataPersister;

use DateTime;
use App\Entity\User;
use App\Entity\C;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class UserDataPersister implements DataPersisterInterface
{
    private UserPasswordHasherInterface $passwordHasher;
    
    private EntityManagerInterface $entityManager;
    
    public function __construct(UserPasswordHasherInterface $passwordHasher,EntityManagerInterface $entityManager)
    {
        $this->passwordHasher= $passwordHasher;
        
        $this->entityManager = $entityManager;
    }
    public function supports($data): bool
    {
        return $data instanceof User;
    }
    /**
    * @param User $data
    */
    public function persist($data)
    {
        $hashedPassword = $this->passwordHasher->hashPassword($data,$data->getPassword());
        
        $data->setPassword($hashedPassword);

        $data->setCommandeAt(new DateTime());
        
        $this->entityManager->persist($data);
        
        $this->entityManager->flush();
    }

    
    public function remove($data)
    {
        $this->entityManager->remove($data);
        
        $this->entityManager->flush();
    }
}