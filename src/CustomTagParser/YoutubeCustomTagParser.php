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

        return $this->getEmbed("https://www.youtube.com/embed/" . $tag_value);
    }

    /**
     * @param string $video_url
     * @return string
     */
    public function getEmbed($video_url)
    {
        return sprintf('<iframe width="'. $this->width . '" height="' . $this->height. '" src="%s" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>', $video_url);
    }
}