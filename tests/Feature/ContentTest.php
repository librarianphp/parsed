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

test('it loads content and parses front matter', function () use($content) {
    $parser = new ContentParser();
    $article = $parser->parse($content);

    expect($article->title)->toEqual("Content Title");
    expect($article->custom)->toEqual("custom");
    expect($article->frontMatterHas('custom'))->toBeTrue();
    expect($article->frontMatterGet('custom'))->toEqual('custom');
});

test('it loads content and parses markdown', function () use($content) {
    $parser = new ContentParser();
    $article = $parser->parse($content);

    expect($article->body_html)->toEqual("<h2>Testing</h2>");
});