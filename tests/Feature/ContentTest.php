<?php

use Parsed\Content;
use Parsed\ContentParser;

$content = "---\n";
$content .= "title: Content Title\n";
$content .= "description: My Description\n";
$content .= "custom: custom\n";
$content .= "---\n";
$content .= "## Testing";

test('it creates content from raw markdown', function () use($content) {
    $content = new Content($content);

    expect($content->raw)->toBeString();
});

test('it parses content with front matter', function () use($content) {
    $content = new Content($content);
    $content->parse(new ContentParser());
    print_r($content);
    expect($content->title)->toEqual("Content Title");
    expect($content->body_html)->toEqual("<h2>Testing</h2>");
});

test('it creates a valid front matter', function () use($content) {
    $article = new Content();
    $article->frontMatterSet('title', 'Content Title');
    $article->frontMatterSet('description', 'My Description');
    $article->frontMatterSet('custom', 'custom');
    $article->updateRaw();

    $content = new Content($content);
    $content->parse(new ContentParser());

    expect($article->getFrontMatter())->toEqual($content->getFrontMatter());
    expect($content->custom)->toEqual($content->custom);
});