<?php

namespace App\Controller;

use App\Entity\Quote;
use App\Repository\QuoteRepository;
use App\Services\HelperParserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class QuoteController extends AbstractController
{
    /**
     * @Route("/quotes", name="quotes")
     * @param QuoteRepository $quoteRepository
     * @param HelperParserService $helperParser
     * @return Response
     */
    public function index(QuoteRepository $quoteRepository, HelperParserService $helperParser): Response
    {
        $quotes = $quoteRepository->findAll();

        return $this->render('quote/index.html.twig', [
            'quotes' => $helperParser->parseObjects(
                $quotes,
                ['title', 'content'],
            ),
        ]);
    }
}
