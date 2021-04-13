<?php
use Parsed\Content;
use Parsed\ContentParser;

beforeEach(function () {
    $content = "---\n";
    $content .= "title: Content Title\n";
    $content .= "description: My Description\n";
    $content .= "custom: custom\n";
    $content .= "---\n";
    $content .= "## Testing";

    $this->twitter_content = $content . "\n{% twitter 1121340649649967104 %}";
    $this->youtube_content = $content . "\n{% youtube Pfkp-lrJTWM %}";
    $this->github_content = $content . "\n{% github https://github.com/erikaheidi/parsed/blob/main/composer.json %}";
});

test('it parses twitter liquid tag', function () {
    $parser = new ContentParser();
    $article = $parser->parse(new Content($this->twitter_content), true);

    expect($article->body_html)->toContain("https://twitter.com");
});

test('it parses youtube liquid tag', function () {
    $parser = new ContentParser();
    $article = $parser->parse(new Content($this->youtube_content), true);

    expect($article->body_html)->toContain("https://www.youtube.com/embed/");
});

test('it parses github liquid tag', function () {
    $parser = new ContentParser();
    $article = $parser->parse(new Content($this->github_content), true);

    expect($article->body_html)->toContain('"name": "erikaheidi/parsed"');
});