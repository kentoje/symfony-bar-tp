<?php

namespace App\Controller;

use App\Repository\BeerRepository;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    /**
     * @Route("/category/{id}", name="category")
     * @param CategoryRepository $categoryRepository
     * @param BeerRepository $beerRepository
     * @param int $id
     * @return Response
    */
    public function index(
        CategoryRepository $categoryRepository,
        BeerRepository $beerRepository,
        int $id
    ): Response
    {
        return $this->render('category/index.html.twig', [
            'category' => $categoryRepository->findOneBy(['id' => $id]),
            'beers' => $beerRepository->findBeersByCategory($id),
        ]);
    }
}
