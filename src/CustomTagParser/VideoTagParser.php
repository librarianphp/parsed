<?php

namespace Parsed\CustomTagParser;

use Parsed\CustomTagParserInterface;

class VideoTagParser implements CustomTagParserInterface
{
    public function parse(string $tag_value, array $params = []): string
    {
        return "<video controls>" .
         "<source src=\"$tag_value\" type=\"video/mp4\">" .
         "Your browser does not support the video tag." .
         "</video>";
    }
}
