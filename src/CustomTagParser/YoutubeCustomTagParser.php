<?php

namespace Parsed\CustomTagParser;

use Parsed\CustomTagParserInterface;

class YoutubeCustomTagParser implements CustomTagParserInterface
{
    protected $width;
    protected $height;

    /**
     * @param string $tag_value
     * @param array $params
     * @return string
     */
    public function parse($tag_value, array $params = [])
    {
        $this->width = $params['width'] ?? 560;
        $this->height = $params['height'] ?? 315;

        return $this->getEmbed($tag_value);
    }

    /**
     * @param string $video_url
     * @return string
     */
    public function getEmbed($tag_value)
    {
        return '<div class="relative" style="padding-top: 56.25%">
          <iframe class="absolute inset-0 w-full h-full" src="https://www.youtube.com/embed/' . $tag_value .'" frameborder="0"></iframe>
        </div>';
    }
}
