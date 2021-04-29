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

test('it creates content from raw markdown', function () {
    $content = new Content($this->raw_content);

    expect($content->raw)->toBeString();
});

test('it parses content with front matter', function () {
    $content = new Content($this->raw_content);
    $content->parse(new ContentParser(), true);
    expect($content->title)->toEqual("Content Title");
    expect($content->body_html)->toEqual("<h2>Testing</h2>\n");
});

test('it creates a valid front matter', function () {
    $article = new Content();
    $article->frontMatterSet('title', 'Content Title');
    $article->frontMatterSet('description', 'My Description');
    $article->frontMatterSet('custom', 'custom');
    $article->updateRaw();

    $content = new Content($this->raw_content);
    $content->parse(new ContentParser());

    expect($article->getFrontMatter())->toEqual($content->getFrontMatter());
    expect($content->custom)->toEqual($content->custom);
});
