<?php
use Parsed\Content;
use Parsed\ContentParser;

$content = "---\n";
$content .= "title: Content Title\n";
$content .= "description: My Description\n";
$content .= "custom: custom\n";
$content .= "---\n";
$content .= "## Testing";

$twitter_content = $content . "\n{% twitter 1121340649649967104 %}";
$youtube_content = $content . "\n{% youtube Pfkp-lrJTWM %}";
$github_content = $content . "\n{% github https://github.com/erikaheidi/parsed/blob/main/composer.json %}";

test('it parses twitter liquid tag', function () use($twitter_content) {
    $parser = new ContentParser();
    $article = $parser->parse($twitter_content);

    expect($article->body_html)->toContain("https://twitter.com");
});

test('it parses youtube liquid tag', function () use($youtube_content) {
    $parser = new ContentParser();
    $article = $parser->parse($youtube_content);

    expect($article->body_html)->toContain("https://www.youtube.com/embed/");
});

test('it parses github liquid tag', function () use($github_content) {
    $parser = new ContentParser();
    $article = $parser->parse($github_content);

    expect($article->body_html)->toContain('"name": "erikaheidi/parsed"');
});