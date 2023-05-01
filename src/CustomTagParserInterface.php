<?php

namespace Parsed;

interface CustomTagParserInterface
{
    public function parse(string $tag_value, array $params = []);
}
