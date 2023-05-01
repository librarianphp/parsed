<?php

namespace Parsed;

/**
 * Defines a Content Model
 * @package Miniweb
 */
class Content
{
    /** @var ?string Raw content */
    public ?string $raw = "";

    /** @var array Front-matter key-pairs */
    public array $front_matter = [];

    /** @var string Body of content in markdown */
    public string $body_markdown = "";

    /** @var string Body of content in html */
    public string $body_html = "";

    /**
     * Content constructor.
     * @param null $content
     */
    public function __construct($content = null)
    {
        $this->raw = $content;
    }

    /**
     * Explodes front mater value into array (for tags and similar)
     * @param string $key
     * @return array
     */
    public function getAsArray(string $key): array
    {
        $collection = [];

        if ($this->frontMatterHas($key)) {
            $collection = explode(',', $this->frontMatterGet($key));
        }

        return $collection;
    }

    /**
     * @param string $key
     * @return bool
     */
    public function frontMatterHas(string $key): bool
    {
        return key_exists($key, $this->front_matter);
    }

    /**
     * @param string $key
     * @param ?string $default_value
     * @return ?string
     */
    public function frontMatterGet(string $key, ?string $default_value = null): ?string
    {
        if ($this->frontMatterHas($key)) {
            return $this->front_matter[$key] ?: $default_value;
        }

        return $default_value;
    }

    /**
     * @param string $key
     * @param string $value
     */
    public function frontMatterSet(string $key, string $value): void
    {
        $this->front_matter[$key] = $value;
    }

    /**
     * @param ContentParser $parser
     * @param bool $parse_markdown
     */
    public function parse(ContentParser $parser, bool $parse_markdown = false): void
    {
        $parser->parse($this, $parse_markdown);
    }

    /**
     * @return string
     */
    public function getFrontMatter(): string
    {
        $content = "---\n";
        foreach ($this->front_matter as $key => $value) {
            $content .= "$key: $value\n";
        }
        $content .= "---\n";

        return $content;
    }

    public function updateRaw(): void
    {
        $raw = $this->getFrontMatter();
        $raw .= $this->body_markdown;

        $this->raw = $raw;
    }
}
