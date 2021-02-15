<?php

namespace App\Controller;

use App\Repository\BeerRepository;
use App\Repository\CategoryRepository;
use App\Repository\CountryRepository;
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
   * @param CountryRepository $countryRepository
   * @param CategoryRepository $categoryRepository
   * @param int $id
   * @return Response
   */
    public function beer(
        BeerRepository $beerRepository,
        CountryRepository $countryRepository,
        CategoryRepository $categoryRepository,
        int $id
    ): Response
    {
        $beer = $beerRepository->find($id);
        $idCountry = $beer->getCountry()->getId();
        $countryRepository->findOneBy(['id' => $idCountry]);
        $categories = $categoryRepository->findCatSpecial($id);

        $categoriesName = array_map(function ($element) {
            return $element->getName();
        }, $categories);

        return $this->render('beer/beer.html.twig', [
            'beer' => $beer,
            'categories' => $categoriesName,
        ]);
    }
}
