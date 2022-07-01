<?php


//CollectionDataProviderInterface est utilisé lors de la récupération d'une collection .
//ItemDataProviderInterface est utilisé lors de la récupération des éléments.


namespace App\DataProvider;

use ApiPlatform\Core\DataProvider\ContextAwareCollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\Entity\Catalogue;
use App\Repository\BurgerRepository;
use App\Repository\CatalogueRepository;
use App\Repository\MenuRepository;

class CatalogueProvider implements ContextAwareCollectionDataProviderInterface, RestrictedDataProviderInterface
{
    private MenuRepository $menus;
    private BurgerRepository $burgers;

    public function __construct(MenuRepository $menus,BurgerRepository $burgers)
    {
        $this->menus=$menus;

        $this->burgers=$burgers;
        
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return Catalogue::class === $resourceClass;
    }

    public function getCollection(string $resourceClass, string $operationName = null, array $context = [])
    {
        $catalogue=[];
        $m=$menus->fin

        



        try {
                $collection = $this->repository->getMenus();

                dd($collection);
        } 
        catch (\Exception $e){

            throw new \RuntimeException(sprintf('Unable to retrieve catalogue from external source: %s', $e->getMessage()));
        }

        
    }
}