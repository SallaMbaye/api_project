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

            $frites=$data->getMenufrites();

            for ($i=0; $i < count($frites); $i++) { 

                $prix=0;

                $prix=$frites[$i]->getPortionfrite()->getPrix()*$frites[$i]->getQte();

                $prixmenu+=$prix;


            }
            
            $tailles=$data->getMenutailles();

            for ($i=0; $i < count($tailles); $i++) { 

                $prix=$tailles[$i]->getTaille()->getPrix()*$tailles[$i]->getQte();

                $prixmenu+=$prix;


            }
            
            $burgers=$data->getMenuburgers();
            
            for ($i=0; $i < count($burgers); $i++) { 

                $prix=$burgers[$i]->getBurger()->getPrix()*$burgers[$i]->getQte();

                $prix=$prix*$qte;

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