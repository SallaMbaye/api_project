<?php

namespace App\Controller;

use App\Entity\Zone;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ZoneController extends AbstractController
{
    /* #[Route('/zone', name: 'app_zone')]
    public function index(): Response
    {
        return $this->render('zone/index.html.twig', [
            'controller_name' => 'ZoneController',
        ]);
    } */
    
    public function __invoke(Zone $data): Zone
    {
        dd('ok');

        //$this->bookPublishingHandler->handle($data);

        return $data;
    }
}
