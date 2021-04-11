<?php

use Parsed\Content;
use Parsed\ContentParser;

$content = "---\n";
$content .= "title: Content Title\n";
$content .= "description: My Description\n";
$content .= "custom: custom\n";
$content .= "---\n";
$content .= "## Testing";

test('it creates content', function () use($content) {
    $content = new Content($content);

    expect($content->raw)->toBeString();
});