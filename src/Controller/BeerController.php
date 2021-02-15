<?php

namespace App\Controller;

use App\Repository\BeerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BeerController extends AbstractController
{
    /**
     * @Route("/beer", name="beer")
     * @param BeerRepository $beerRepository
     * @return Response
     */
    public function index(BeerRepository $beerRepository): Response
    {

        $beers = $beerRepository->lastThreeBeers();

        return $this->render('beer/beer-three.html.twig', [
            'thebarContent' => [
                'title' => 'The Bar',
                'content' => $beers,
            ],
        ]);
    }

    /**
     * @Route("/beer/all", name="beerAll")
     * @param BeerRepository $beerRepository
     * @return Response
     */
    public function beers(BeerRepository $beerRepository): Response
    {
        $beers = $beerRepository->findAll();

        return $this->render('beer/index.html.twig', [
            'beers' => [
                'title' => 'The beers',
                'content' => $beers,
            ],
        ]);
    }

    /**
     * @Route("/beer/{id}", name="beer_id")
     * @param BeerRepository $beerRepository
     * @param int $id
     * @return Response
     */
    public function beer(BeerRepository $beerRepository, int $id): Response
    {
        $beer = $beerRepository->find($id);

        return $this->render('beer/beer.html.twig', [
            'beer' => $beer,
        ]);
    }
}
