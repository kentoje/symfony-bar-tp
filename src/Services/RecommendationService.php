<?php

namespace App\Services;

use App\Repository\StatisticRepository;

class RecommendationService {
    private StatisticRepository $statistic;

    public function __construct(StatisticRepository $statisticRepository)
    {
        $this->statistic = $statisticRepository;
    }

    public function addRecommendation(array $arr): array
    {
        return array_map(function($obj) {
            $evaluation = $this->statistic->findOneBy(['beer' => $obj->getId()]);

            if (!$evaluation) {
                return ['info' => $obj,];
            }

            return [
                'info' => $obj,
                'recommended' => $evaluation->getScore() >= 16,
            ];
        }, $arr);
    }

    public function filterRecommendation($arr): array
    {
        return array_filter($this->addRecommendation($arr), static function ($obj) {
            return isset($obj['recommended']) && $obj['recommended'];
        });
    }
}