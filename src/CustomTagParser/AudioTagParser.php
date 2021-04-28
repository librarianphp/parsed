<?php


namespace Parsed\CustomTagParser;

use Parsed\CustomTagParserInterface;

class AudioTagParser implements CustomTagParserInterface
{
    public function parse($tag_value, array $params = [])
    {
        return "<audio controls>" .
            "<source src=\"/audio/$tag_value\" type=\"audio/mpeg\">" .
            "Your browser does not support the audio element." .
            "</audio>";
    }
}