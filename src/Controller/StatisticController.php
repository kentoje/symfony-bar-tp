<?php

namespace App\Controller;

use App\Repository\ClientRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StatisticController extends AbstractController
{
    /**
     * @Route("/statistic", name="statistic")
     * @param ClientRepository $clientRepository
     * @return Response
     */
    public function index(ClientRepository $clientRepository): Response
    {
        $clients = $clientRepository->findAllOrderByBeerDesc();

        return $this->render('statistic/index.html.twig', [
            'data' => [
                'clients' => $clients,
                'count' => count($clients),
                'average' => $clientRepository->calcAverageBeerPerClient(),
                'stdDeviation' => $clientRepository->findStandardDeviationFromNumBeer(),
            ],
        ]);
    }
}
