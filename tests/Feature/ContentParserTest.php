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

    $this->raw_content = $content;
});

test('it parses and returns a Content object', function () {
    $parser = new ContentParser();
    $article = $parser->parse(new Content($this->raw_content));

    expect($article)->toBeObject();
    expect($article->raw)->toBeString();
});

test('it loads content and parses front matter', function () {
    $parser = new ContentParser();
    $article = $parser->parse(new Content($this->raw_content));

    expect($article->title)->toEqual("Content Title");
    expect($article->custom)->toEqual("custom");
    expect($article->frontMatterHas('custom'))->toBeTrue();
    expect($article->frontMatterGet('custom'))->toEqual('custom');
});

test('it loads content and parses markdown', function () {
    $parser = new ContentParser();
    $article = $parser->parse(new Content($this->raw_content));

    expect($article->body_html)->toEqual("<h2>Testing</h2>");
});