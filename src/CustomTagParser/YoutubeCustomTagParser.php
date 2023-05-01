<?php

namespace Parsed\CustomTagParser;

use Minicli\FileNotFoundException;
use Minicli\Stencil;
use Parsed\CustomTagParserInterface;

class YoutubeCustomTagParser implements CustomTagParserInterface
{
    protected int $width;
    protected int $height;
    protected string $tplDir;

    /**
     * @param string $tag_value
     * @param array $params
     * @return string
     * @throws FileNotFoundException
     */
    public function parse(string $tag_value, array $params = []): string
    {
        $this->width = $params['width'] ?? 560;
        $this->height = $params['height'] ?? 315;
        $this->tplDir = $params['stencilDir'] ?? __DIR__ . '/../../tpl';

        return $this->getEmbed($tag_value);
    }

    /**
     * @param string $tag_value
     * @return string
     * @throws FileNotFoundException
     */
    public function getEmbed(string $tag_value): string
    {
        $stencil = new Stencil($this->tplDir);

        return $stencil->applyTemplate('youtube', [
            'tag_value' => $tag_value,
            'width' => $this->width,
            'height' => $this->height
        ]);
    }
}
