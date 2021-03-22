<?php

namespace App\Services;

class MixService {
    public function mixArray(array $arr): array
    {
        // Side effect
        shuffle($arr);

        return $arr;
    }
}