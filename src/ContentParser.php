<?php

namespace Parsed;

use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\Autolink\AutolinkExtension;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\Extension\Strikethrough\StrikethroughExtension;
use League\CommonMark\Extension\Table\TableExtension;
use League\CommonMark\Extension\TaskList\TaskListExtension;
use League\CommonMark\Parser\MarkdownParser;
use League\CommonMark\Renderer\HtmlRenderer;
use Parsed\CustomTagParser\AudioTagParser;
use Parsed\CustomTagParser\GithubCustomTagParser;
use Parsed\CustomTagParser\TwitterCustomTagParser;
use Parsed\CustomTagParser\VideoTagParser;
use Parsed\CustomTagParser\YoutubeCustomTagParser;

/**
 * Class ContentParser
 * Parses a markdown content with an optional front matter
 */
class ContentParser
{
    /** @var string  */
    protected $original_content;

    /** @var array */
    protected $front_matter;

    /** @var string */
    protected $markdown;

    /** @var array */
    protected $custom_tag_parsers;

    /** @var array */
    protected $parser_params;

    /**
     * ContentParser constructor.
     * @param array $parser_params
     */
    public function __construct(array $parser_params = [])
    {
        $this->parser_params = $parser_params;
        $this->addCustomTagParser('video', new VideoTagParser());
        $this->addCustomTagParser('audio', new AudioTagParser());
        $this->addCustomTagParser('twitter', new TwitterCustomTagParser());
        $this->addCustomTagParser('youtube', new YoutubeCustomTagParser());
        $this->addCustomTagParser('github', new GithubCustomTagParser());
    }

    public function addCustomTagParser($name, CustomTagParserInterface $tag_parser)
    {
        $this->custom_tag_parsers[$name] = $tag_parser;
    }

    /**
     * Parses the content and returns a Content object
     */
    public function parse(Content $article, bool $parse_markdown = false): Content
    {
        $parts = preg_split('/[\n]*[-]{3}[\n]/', $article->raw, 3);

        if (count($parts) > 2) {
            $article->front_matter = $this->getFrontMatter($parts[1]);
            $article->body_markdown = $parts[2];
        } else {
            $article->front_matter = [];
            $article->body_markdown = $article->raw;
        }

        if ($parse_markdown) {
            $article->body_html = $this->getHtmlBody($article->body_markdown);
        }

        return $article;
    }

    /**
     * Extracts front-matter from content
     * @param string $front_matter
     * @return array
     */
    public function getFrontMatter(string $front_matter): array
    {
        $parts = preg_split('/[\n]*[\n]/', $front_matter);

        $vars = [];
        foreach ($parts as $line) {
            $content = explode(':', $line, 2);
            if (count($content) > 1) {
                $vars[$content[0]] = trim($content[1]);
            }
        }

        return $vars;
    }

    /**
     * @return string|string[]|null
     * @throws \Exception
     */
    public function getHtmlBody($markdown)
    {
        $environment = new Environment();
        $environment->addExtension(new CommonMarkCoreExtension());
        $environment->addExtension(new StrikethroughExtension());
        $environment->addExtension(new TableExtension());
        $environment->addExtension(new TaskListExtension());
        $environment->addExtension(new AutolinkExtension());

        $parser = new MarkdownParser($environment);
        $renderer = new HtmlRenderer($environment);

        try {
            $markdown = $this->parseSpecial($markdown);
            $document = $parser->parse($markdown);
            return $renderer->renderDocument($document)->__toString();
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Parses special tags such as {% youtube xyz %}
     * @param string $text
     * @return string
     */
    public function parseSpecial($text)
    {
        return preg_replace_callback_array([
            '/^\{%\s(.*)\s(.*)\s%}/m' => function ($match) {
                if (array_key_exists($match[1], $this->custom_tag_parsers)) {
                    $parser = $this->custom_tag_parsers[$match[1]];
                    if ($parser instanceof CustomTagParserInterface) {
                        $params = $this->parser_params[$match[1]] ?? [];
                        return $parser->parse($match[2], $params);
                    }
                }

                return $match[2];
            },
        ], $text);
    }
}
