<?php


namespace Parsed;

use DateTime;

/**
 * Defines a Content Model
 * @package Miniweb
 */
class Content
{
    /** @var string Raw content */
    public $raw;

    /** @var array Front-matter key-pairs */
    public $front_matter;

    /** @var string Body of content in markdown */
    public $body_markdown;

    /** @var string Body of content in html */
    public $body_html;

    /**
     * Content constructor.
     * @param null $content
     */
    public function __construct($content = null)
    {
        $this->raw = $content;
    }

    public function __get($key)
    {
        return $this->frontMatterGet($key);
    }

    /**
     * @return array
     */
    public function getTagsAsArray(): array
    {
        $tags = [];

        if ($this->tag_list) {
            $article_tags = explode(',', $this->tag_list);

            foreach ($article_tags as $article_tag) {
                $tag_name = trim(str_replace('#', '', $article_tag));

                $tags[] = $tag_name;
            }
        }

        return $tags;
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
     * @param string $default_value
     * @return string|null
     */
    public function frontMatterGet(string $key, $default_value = null)
    {
        if ($this->frontMatterHas($key)) {
            return $this->front_matter[$key] ?: $default_value;
        }

        return $default_value;
    }
}