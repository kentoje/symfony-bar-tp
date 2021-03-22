<?php

namespace App\Services;

use cebe\markdown\Markdown;

class HelperParserService {
    private Markdown $parser;

    public function __construct(Markdown $parser)
    {
        $this->parser = $parser;
    }

    public function parse(string $content): string
    {
        return $this
            ->parser
            ->parse($content)
        ;
    }

    public function parseObjects(array $objs, array $keys): array
    {
        $methods = array_map(static function ($key) {
            return [
                sprintf('get%s', ucfirst($key)),
                sprintf('set%s', ucfirst($key))
            ];
        }, $keys);

        return array_map(function ($obj) use ($methods) {
            foreach ($methods as [$get, $set]) {
                $obj->{$set}($this->parse($obj->{$get}()));
            }

            return $obj;
        }, $objs);
    }
}