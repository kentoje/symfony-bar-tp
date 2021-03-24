<?php

namespace App\Controller;

use App\Repository\BeerRepository;
use App\Repository\CategoryRepository;
use App\Repository\CountryRepository;
use App\Repository\StatisticRepository;
use App\Services\HelloService;
use App\Services\HelperParserService;
use App\Services\RecommendationService;
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
     * @param RecommendationService $recommendationService
     * @return Response
     */
    public function beers(BeerRepository $beerRepository, RecommendationService $recommendationService): Response
    {
        $beers = $beerRepository->findAll();

        return $this->render('beer/beers.html.twig', [
            'beers' => [
                'title' => 'The beers',
                'content' => $recommendationService->addRecommendation($beers),
            ],
        ]);
    }

    /**
     * @Route("/beer/recommended", name="beer_recommended")
     * @param BeerRepository $beerRepository
     * @return Response
     */
    public function recommended(BeerRepository $beerRepository): Response
    {
        return $this->render('beer/recommended.html.twig', [
            'beers' => [
                'title' => 'The beers',
                'content' => $beerRepository->findBeersByScoreGreaterThan(16),
            ],
        ]);
    }

    /**
     * @Route("/beer/{id}", name="beer")
     * @param BeerRepository $beerRepository
     * @param StatisticRepository $statisticRepository
     * @param CountryRepository $countryRepository
     * @param CategoryRepository $categoryRepository
     * @param int $id
     * @return Response
     */
    public function beer(
        BeerRepository $beerRepository,
        StatisticRepository $statisticRepository,
        CountryRepository $countryRepository,
        CategoryRepository $categoryRepository,
        int $id
    ): Response
    {
        $beer = $beerRepository->findOneBy(['id' => $id]);

        if (!$beer) {
            return $this->redirectToRoute('homepage');
        }

        $beerStat = $statisticRepository->findOneBy(['beer' => $id]);

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
            'evaluation' => $beerStat ? $beerStat->getScore() : null,
            'categories' => $categoriesName,
        ]);
    }
}
