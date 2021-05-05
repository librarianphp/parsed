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

    expect($article->frontMatterGet('title'))->toEqual("Content Title");
    expect($article->frontMatterGet('custom'))->toEqual("custom");
    expect($article->frontMatterHas('custom'))->toBeTrue();
});

test('it loads content and parses markdown', function () {
    $parser = new ContentParser();
    $article = $parser->parse(new Content($this->raw_content), true);

    expect($article->body_html)->toEqual("<h2>Testing</h2>\n");
});

test('it parses backticks as inline code blocks', function () {
    $parser = new ContentParser();
    $content = $this->raw_content . "\ntrying `parsed`\n";
    $article = $parser->parse(new Content($content), true);

    expect($article->body_html)->toContain("<code>parsed</code>");
});

test('it parses markdown when from matter is not set', function () {
    $parser = new ContentParser();
    $content = "Trying `parsed`\n";

    $article = $parser->parse(new Content($content), true);
    expect($article->body_html)->not()->toBeNull();
    expect($article->body_html)->toContain("<code>parsed</code>");
});