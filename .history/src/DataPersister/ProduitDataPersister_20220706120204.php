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

            $frites=$data->getMenufrites();
            $tailles=$data->getMenutailles();
            $burgers=$data->getMenuburgers();
            $prix=0;
                        

        
            dd($data->getMenufrites());
        }
        
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