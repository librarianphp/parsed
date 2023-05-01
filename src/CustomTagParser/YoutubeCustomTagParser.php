<?php

namespace Parsed\CustomTagParser;

use Parsed\CustomTagParserInterface;

class YoutubeCustomTagParser implements CustomTagParserInterface
{
    protected int $width;
    protected int $height;

    /**
     * @param string $tag_value
     * @param array $params
     * @return string
     */
    public function parse(string $tag_value, array $params = []): string
    {
        $this->width = $params['width'] ?? 560;
        $this->height = $params['height'] ?? 315;

        return $this->getEmbed($tag_value);
    }

    /**
     * @param string $tag_value
     * @return string
     */
    public function getEmbed(string $tag_value): string
    {
        return '<div class="relative" style="padding-top: 56.25%">
          <iframe class="absolute inset-0 w-full h-full" src="https://www.youtube.com/embed/' . $tag_value .'" frameborder="0"></iframe>
        </div>';
    }
}
