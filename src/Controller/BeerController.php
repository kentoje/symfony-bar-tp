<?php

namespace App\Controller;

use App\Repository\BeerRepository;
use App\Repository\CategoryRepository;
use App\Repository\CountryRepository;
use App\Services\HelloService;
use App\Services\HelperParserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BeerController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     * @param BeerRepository $beerRepository
     * @return Response
     */
    public function index(BeerRepository $beerRepository): Response
    {
        return $this->render('beer/index.html.twig', [
            'data' => [
                'title' => 'The Bar',
                'beers' => $beerRepository->findBeersDesc(3),
            ],
        ]);
    }

    /**
     * @Route("/showService", name="showService")
     * @param HelloService $hello
     * @param HelperParserService $helperParser
     * @return Response
     */
    public function showService(HelloService $hello, HelperParserService $helperParser): Response
    {
        $content = "* Pommes \n* Poires
    * Sous élément avec au moins quatre espaces devant.";

        return $this->render('hello/index.html.twig', [
            'hello' => $hello->say(),
            'markdown' => $helperParser->parse($content)
        ]);
    }

    /**
     * @Route("/beer/all", name="beers")
     * @param BeerRepository $beerRepository
     * @return Response
    */
    public function beers(BeerRepository $beerRepository): Response
    {
        return $this->render('beer/beers.html.twig', [
            'beers' => [
                'title' => 'The beers',
                'content' => $beerRepository->findAll(),
            ],
        ]);
    }

    /**
     * @Route("/beer/{id}", name="beer")
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
        $beer = $beerRepository->findOneBy(['id' => $id]);

        if (!$beer) {
            return $this->redirectToRoute('homepage');
        }

        if ($beer->getCountry()) {
            $idCountry = $beer->getCountry()->getId();
            $countryRepository->findOneBy(['id' => $idCountry]);
        }

        $categories = $categoryRepository->findSpecialCatByBeerId($id);

        $categoriesName = array_map(static function($category) {
            return $category->getName();
        }, $categories);

        [$normalCategory] = $categoryRepository->findNormalCatByBeerId($id);

        array_unshift($categoriesName, $normalCategory->getName());

        return $this->render('beer/beer.html.twig', [
            'beer' => $beer,
            'categories' => $categoriesName,
        ]);
    }
}
