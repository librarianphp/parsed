<?php


namespace Parsed;

interface CustomTagParserInterface
{
    public function parse($tag_value, array $params = []);
}