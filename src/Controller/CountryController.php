<?php

namespace App\Controller;

use App\Repository\BeerRepository;
use App\Repository\CountryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CountryController extends AbstractController
{
    /**
     * @Route("/countries", name="countries")
     * @param CountryRepository $countryRepository
     * @return Response
    */
    public function index(CountryRepository $countryRepository): Response
    {
        return $this->render('country/index.html.twig', [
            'countries' => $countryRepository->findAll(),
        ]);
    }

    /**
     * @Route("/country/{id}", name="country")
     * @param CountryRepository $countryRepository
     * @param BeerRepository $beerRepository
     * @param int $id
     * @return Response
    */
    public function country(CountryRepository $countryRepository, BeerRepository $beerRepository, int $id): Response
    {
        return $this->render('country/country.html.twig', [
            'country' => $countryRepository->findOneBy(['id' => $id]),
            'beers' => $beerRepository->findAllBeersFromCountry($id),
        ]);
    }
}
