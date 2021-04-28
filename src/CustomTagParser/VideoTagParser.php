<?php


namespace Parsed\CustomTagParser;

use Parsed\CustomTagParserInterface;

class VideoTagParser implements CustomTagParserInterface
{
    public function parse($tag_value, array $params = [])
    {
        return "<video controls>" .
         "<source src=\"/video/$tag_value\" type=\"video/mp4\">" .
         "Your browser does not support the video tag." .
         "</video>";
    }
}