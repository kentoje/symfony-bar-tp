<?php

namespace App\Services;

use cebe\markdown\Markdown;

class HelperParserService {
    private Markdown $parser;

    public function __construct()
    {
        $this->parser = new Markdown();
    }

    public function parse(string $content): string
    {
        return $this
            ->parser
            ->parse($content)
        ;
    }
}