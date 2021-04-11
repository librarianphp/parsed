<?php

use Parsed\Content;
use Parsed\ContentParser;

$content = "---\n";
$content .= "title: Content Title\n";
$content .= "description: My Description\n";
$content .= "custom: custom\n";
$content .= "---\n";
$content .= "## Testing";

test('it parses and returns a Content object', function () use($content) {
    $parser = new ContentParser();
    $article = $parser->parse($content);

    expect($article)->toBeObject();
    expect($article->raw)->toBeString();
});