<?php

namespace App\Controller;

use App\Entity\Beer;
use App\Entity\Category;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BarController extends AbstractController
{
    #[Route('/bar', name: 'bar')]
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

    #[Route('/mention', name: 'mention')]
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

    #[Route('/newbeer', name: 'create_beer')]
    public function createBeer(): Response
    {
        $em = $this->getDoctrine()->getManager();

        $beer = new Beer();
        $beer->setName('Super Beer');
        $beer->setPublishedAt(new DateTime());
        $beer->setDescription('Ergonomic and stylish!');

        $em->persist($beer);
        $em->flush();

        return new Response('Saved new beer with id ' . $beer->getId());
    }

    #[Route('/newcategory', name: 'create_category')]
    public function createCategory(): Response
    {
        $em = $this->getDoctrine()->getManager();

        $category = new Category();
        $category->setName('Super category');
        $category->setDescription('Ergonomic and stylish!');

        $em->persist($category);
        $em->flush();

        return new Response('Saved new category with id ' . $category->getId());
    }

    #[Route('/linkthem', name: 'create_linkthem')]
    public function doStuff(): Response
    {
        $em = $this->getDoctrine()->getManager();
        $beerRepo = $this->getDoctrine()->getRepository(Beer::class);

        $category = new Category();
        $category->setName('Blonde');
        $category->setDescription('Blonde');

        $beers = $beerRepo->findAll();
        foreach($beers as $beer) {
            $beer->addCategory($category);
        }

        $em->persist($category);
        $em->flush();

        return new Response('Done!');
    }
}
