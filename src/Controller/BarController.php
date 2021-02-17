<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BarController extends AbstractController
{
    /**
     * @Route("/mention", name="mention")
    */
    public function mention(): Response
    {
        return $this->render('mention/index.html.twig', [
            'sidebarTitle' => 'Sidebar',
            'data' => [
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

    public function mainMenu(
        CategoryRepository $categoryRepository,
        string $id,
        string $routeName
    ): Response
    {
        $normalCategories = $categoryRepository->findAllNormal();
        $normalCategoriesName = array_map(static function($category) {
            return [
                'id' => $category->getId(),
                'name' => $category->getName(),
            ];
        }, $normalCategories);

        return $this->render('partials/menu.html.twig', [
            'routeName' => $routeName,
            'categoryId' => $routeName === 'beer'
                ? $categoryRepository->findNormalCategoryByBeerId($id)->getId()
                : $id,
            'categories' => $normalCategoriesName
        ]);
    }
}
