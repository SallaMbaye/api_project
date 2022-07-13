<?php

namespace App\DataPersister;


use App\Entity\Menu;
use App\Entity\Produit;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\DataPersister\DataPersisterInterface;


class ProduitDataPersister implements DataPersisterInterface
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager){

        $this->entityManager = $entityManager;

    }



    
    public function supports($data): bool
    {
        return $data instanceof Produit;
    }
    
    /**
    * @param Produit $data
    */

    public function persist($data)
    {

        if($data instanceof Menu){

            $prixmenu=0;

            for ($i=0; $i < count($data->getMenufrites()); $i++) { 

                $prix=$data->getMenufrites()[$i]->getPortionfrite()->getPrix()*$data->getMenufrites()[$i]->getQte();

                $prixmenu+=$prix;

            }

            for ($i=0; $i < count($data->getMenutailles()); $i++) { 

                $prix=$data->getMenutailles()[$i]->getTaille()->getPrix()*$data->getMenutailles()[$i]->getQte();

                $prixmenu+=$prix;


            }
            
            for ($i=0; $i < count($data->getMenuburgers()); $i++) { 

                $prix=$data->getMenuburgers()[$i]->getBurger()->getPrix()*$data->getMenuburgers()[$i]->getQte();

                $prixmenu+=$prix;

            }
        
        }

        $data->setPrix($prixmenu);
        
        $this->entityManager->persist($data);
        
        $this->entityManager->flush();
        
    } 
    public function remove($data)
    {

        $data->setEtat("Archive");

        $this->entityManager->persist($data);
        
        $this->entityManager->flush();
    }
}