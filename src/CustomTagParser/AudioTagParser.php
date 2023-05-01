<?php

namespace Parsed\CustomTagParser;

use Parsed\CustomTagParserInterface;

class AudioTagParser implements CustomTagParserInterface
{
    public function parse(string $tag_value, array $params = []): string
    {
        return "<audio controls>" .
            "<source src=\"$tag_value\" type=\"audio/mpeg\">" .
            "Your browser does not support the audio element." .
            "</audio>";
    }
}
