<?php

namespace Parsed\CustomTagParser;

use Minicli\FileNotFoundException;
use Minicli\Stencil;
use Parsed\CustomTagParserInterface;

class VideoTagParser implements CustomTagParserInterface
{
    /**
     * @throws FileNotFoundException
     */
    public function parse(string $tag_value, array $params = []): string
    {
        $tplDir = $params['stencilDir'] ?? __DIR__ . '/../../tpl';

        $stencil = new Stencil($tplDir);
        return $stencil->applyTemplate('video', ['tag_value' => $tag_value]);
    }
}
