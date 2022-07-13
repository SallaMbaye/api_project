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
        
        /* if($data instanceof Menu){

            $prix=0;    

            $boissons=$data->getBoissons();

            $burgers=$data->getBurgers();

            $frites=$data->getPortionFrites();

            for ($i=0; $i < count($boissons) ; $i++) { 

                $prix+=$boissons[$i]->getPrix();
   
            }
            for ($j=0; $j < count($burgers) ; $j++) { 

                $prix+=$burgers[$j]->getPrix();
            }

            for ($k=0; $k < count($frites) ; $k++) { 

                $prix+=$frites[$k]->getPrix();
            }

            $data->setPrix($prix);

        }*/

        if($data instanceof Menu){

            $prixmenu=0;

            $frites=$data->getMenufrites();

            for ($i=0; $i < count($frites); $i++) { 

                $prix=0;

                $qte=$frites[$i]->getQte();

                $prix=$frites[$i]->getPortionfrite()->getPrix();

                $prix=$prix*$qte;

                $prixmenu+=$prix;


            }
            
            $tailles=$data->getMenutailles();

            for ($i=0; $i < count($tailles); $i++) { 

                $prix=0;

                $qte=$tailles[$i]->getQte();

                $prix=$tailles[$i]->getTaille()->getPrix();

                $prix=$prix*$qte;

                $prixmenu+=$prix;


            }
            
            $burgers=$data->getMenuburgers();
            
            for ($i=0; $i < count($burgers); $i++) { 

                $prix=0;

                $qte=$burgers[$i]->getQte();

                $prix=$burgers[$i]->getBurger()->getPrix();

                $prix=$prix*$qte;

                $prixmenu+=$prix;


            }
        
        }

        $data->setPrix()
        
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