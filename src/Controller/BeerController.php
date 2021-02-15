<?php

namespace App\Controller;

use App\Repository\BeerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\FetchService;

class BeerController extends AbstractController
{
//    const BEERS_URL = 'https://raw.githubusercontent.com/Antoine07/hetic_symfony/main/Introduction/Data/beers.json';

//    public function __construct(FetchService $fetch)
//    {
//        $this->fetch = $fetch;
//    }

//    private function getBeers(): array
//    {
//        return $this
//            ->fetch
//            ->get(self::BEERS_URL)
//            ->toArray()
//        ;
//    }

    #[Route('/beer', name: 'beer')]
    public function index(BeerRepository $beerRepository): Response
    {
//        $data = $this->getBeers();
        $beers = $beerRepository->findAll();

        return $this->render('beer/index.html.twig', [
            'beers' => [
                'title' => 'The beers',
                'content' => $beers,
            ],
        ]);
    }

    #[Route('/beer/{id}', name: 'beer_id')]
    public function beer(BeerRepository $beerRepository, int $id): Response
    {
        $beer = $beerRepository->find($id);

        return $this->render('beer/beer.html.twig', [
            'beer' => $beer,
        ]);
    }
}
