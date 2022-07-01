<?php

namespace App\Controller;

use App\Repository\MenuRepository;
use App\Repository\BurgerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CatalogueController extends AbstractController
{
    
    public function _invoke(MenuRepository $menurepo, BurgerRepository $burgerepo)
    {
        $catalogue=[];

        $menus = $menurepo->findAll();

        $burgers=$burgerepo->findAll();

        dd($menus); 
        
    }

}