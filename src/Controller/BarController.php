<?php

namespace App\Controller;

use App\Repository\BeerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Beer;

class BarController extends AbstractController
{
    /**
     * @Route("/mention", name="mention")
    */
    public function mention(): Response
    {
        return $this->render('mention/index.html.twig', [
            'sidebarTitle' => 'Sidebar',
            'thebarContent' => [
                'title' => 'Mentions legales',
                'content' => [
                    [
                        'title' => 'Mentions',
                        'text' => 'With supporting text below as a natural lead-in to additional content.',
                    ],
                ]
            ],
        ]);
    }
}
