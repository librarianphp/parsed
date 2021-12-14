<?php

namespace Parsed\CustomTagParser;

use Parsed\CustomTagParserInterface;
use Minicli\Curly\Client;

class GithubCustomTagParser implements CustomTagParserInterface
{
    /**
     * Returns referred github content as a markdown code block.
     * @param $tag_value
     * @param array $params
     * @return string
     */
    public function parse($tag_value, array $params = [])
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
     * @param $github_url
     * @return bool
     */
    public function validateUrl($github_url)
    {
        preg_match('@^(?:https://)?([^/]+)@i', $github_url, $matches);
        return ($matches[1] == 'github.com');
    }

    /**
     * Transforms URL to obtain raw version of content
     *   ex. web: https://github.com/minicli/librarian/blob/master/config_sample.php
     *   ex. raw: https://raw.githubusercontent.com/minicli/librarian/master/config_sample.php
     * @param $github_url
     * @return string
     */
    public function getRawUrl($github_url)
    {
        $raw_url = str_replace('github.com', 'raw.githubusercontent.com', $github_url);
        return str_replace('/blob', '', $raw_url);
    }
}
