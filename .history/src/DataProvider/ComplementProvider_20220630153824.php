<?php


//CollectionDataProviderInterface est utilisé lors de la récupération d'une collection .
//ItemDataProviderInterface est utilisé lors de la récupération des éléments.


namespace App\DataProvider;

use ApiPlatform\Core\DataProvider\ContextAwareCollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\Entity\Complement;
use App\Repository\BoissonRepository;
use App\Repository\CatalogueRepository;
use App\Repository\PortionFriteRepository;

//Service Upload A Créer
//Attribut supplementaire 
//Conversion Blob en un format comprehensible par toute appli

class ComplementProvider implements ContextAwareCollectionDataProviderInterface, RestrictedDataProviderInterface
{
    private BoissonRepository $boissons;
    
    private PortionFriteRepository $portionFrites;

    public function __construct(BoissonRepository $boissons,PortionFriteRepository $portionFrites)
    {
        $this->boissons=$boissons;

        $this->portionFrites=$portionFrites;   
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return Complement::class === $resourceClass;
    }

    public function getCollection(string $resourceClass, string $operationName = null, array $context = []):array
    {
        //Retourner un objet de type catalogue 

        dd($this->boissons->findAll());

        dd($this->portionFrites->findAll());

        try {
                $collection = $this->repository->getboissons();

                dd($collection);
        } 
        catch (\Exception $e){

            throw new \RuntimeException(sprintf('Unable to retrieve catalogue from external source: %s', $e->getMessage()));
        }

        
    }
}