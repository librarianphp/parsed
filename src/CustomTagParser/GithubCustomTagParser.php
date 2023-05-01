<?php

namespace Parsed\CustomTagParser;

use Parsed\CustomTagParserInterface;
use Minicli\Curly\Client;

class GithubCustomTagParser implements CustomTagParserInterface
{
    /**
     * Returns referred GitHub content as a Markdown code block.
     * @param string $tag_value
     * @param array $params
     * @return string
     */
    public function parse(string $tag_value, array $params = []): string
    {
        if ($this->validateUrl($tag_value)) {
            $client = new Client();

            $response = $client->get($this->getRawUrl($tag_value));

            if ($response['code'] == 200) {
                return "```\n" . $response['body'] . "\n```";
            }
        }

        return $tag_value;
    }

    /**
     * Validates a Github URL
     * @param string $github_url
     * @return bool
     */
    public function validateUrl(string $github_url): bool
    {
        preg_match('@^(?:https://)?([^/]+)@i', $github_url, $matches);
        return ($matches[1] == 'github.com');
    }

    /**
     * Transforms URL to obtain raw version of content
     *   ex. web: https://github.com/minicli/librarian/blob/master/config_sample.php
     *   ex. raw: https://raw.githubusercontent.com/minicli/librarian/master/config_sample.php
     * @param string $github_url
     * @return string
     */
    public function getRawUrl(string $github_url): string
    {
        $raw_url = str_replace('github.com', 'raw.githubusercontent.com', $github_url);
        return str_replace('/blob', '', $raw_url);
    }
}
