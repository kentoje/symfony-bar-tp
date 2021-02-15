<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BarController extends AbstractController
{
    /**
     * @Route("/bar", name="bar")
    */
    public function bar(): Response
    {
        return $this->render('bar/index.html.twig', [
            'sidebarTitle' => 'Sidebar',
            'thebarContent' => [
                'title' => 'The Bar',
                'content' => [
                    [
                        'title' => 'Special title treatment',
                        'text' => 'With supporting text below as a natural lead-in to additional content.',
                        'buttonText' => 'Go somewhere',
                    ],
                    [
                        'title' => 'Special title treatment',
                        'text' => 'With supporting text below as a natural lead-in to additional content.',
                        'buttonText' => 'Go somewhere',
                    ],
                ]
            ],
        ]);
    }

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
