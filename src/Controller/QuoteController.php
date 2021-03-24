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
    public const PRIORITY_NONE = 'none';
    public const PRIORITY_IMPORTANT = 'important';

    /**
     * @Route("/quotes", name="quotes")
     * @param QuoteRepository $quoteRepository
     * @param HelperParserService $helperParser
     * @return Response
     */
    public function index(QuoteRepository $quoteRepository, HelperParserService $helperParser): Response
    {
        $quotesImportant = $quoteRepository->findBy(
            ['position' => self::PRIORITY_IMPORTANT],
            ['created_at' => 'DESC'],
        );
        $quotesNone = $quoteRepository->findBy(
            ['position' => self::PRIORITY_NONE],
            ['created_at' => 'DESC'],
        );
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
     * @Route("/quote/modify/{id}", name="quote_modify", methods={"GET", "POST"})
     * @param Request $request
     * @param QuoteRepository $quoteRepository
     * @param EntityManagerInterface $manager
     * @param null $id
     * @return Response
     */
    public function new(
        Request $request,
        QuoteRepository $quoteRepository,
        EntityManagerInterface $manager,
        $id = null
    ): Response
    {
        $quote = $quoteRepository->findOneBy(['id' => $id]);

        if (!$quote && $request->attributes->get('_route') === 'quote_modify') {
            throw $this->createNotFoundException('The quote does not exist.');
        }

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

    /**
     * @Route("/quote/delete/{id}", name="quote_delete", methods={"POST", "GET"})
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @param QuoteRepository $quoteRepository
     * @param $id
     * @return Response
     */
    public function delete(
        Request $request,
        EntityManagerInterface $manager,
        QuoteRepository $quoteRepository,
        $id
    ): Response
    {
        if ($request->isMethod('GET')) {
            return $this->redirectToRoute('quotes');
        }

        $quote = $quoteRepository->findOneBy(['id' => $id]);

        if (!$quote) {
            throw $this->createNotFoundException('The quote does not exist.');
        }

        $manager->remove($quote);
        $manager->flush();

        return $this->redirectToRoute('quotes');
    }
}
