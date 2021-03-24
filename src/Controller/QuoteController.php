<?php

namespace App\Controller;

use App\Entity\Quote;
use App\Form\QuoteType;
use App\Repository\QuoteRepository;
use App\Services\HelperParserService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
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
        $quotesImportant = $quoteRepository->findBy(['position' => 'important'], ['created_at' => 'DESC']);
        $quotesNone = $quoteRepository->findBy(['position' => 'none'], ['created_at' => 'DESC']);
        $quotes = [
            ...$quotesImportant,
            ...$quotesNone,
        ];

        return $this->render('quote/index.html.twig', [
            'quotes' => $helperParser->parseObjects(
                $quotes,
                ['title', 'content'],
            ),
        ]);
    }

    /**
     * @Route("/quote/new", name="quote_new", methods={"GET", "POST"})
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @param Quote|null $quote
     * @return Response
     */
    public function new(Request $request, EntityManagerInterface $manager, Quote $quote = null): Response
    {
        if (!$quote) {
            $quote = new Quote();
        }

        $form = $this->createForm(QuoteType::class, $quote);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($quote);
            $manager->flush();

            return $this->redirectToRoute('quotes');
        }

        return $this->render('quote/new.html.twig', [
            'quote' => $quote,
            'form' => $form->createView(),
        ]);
    }
}
