<?php

namespace Parsed\CustomTagParser;

use Parsed\CustomTagParserInterface;
use Minicli\Curly\Client;

class TwitterCustomTagParser implements CustomTagParserInterface
{
    /**
     * @param string $tag_value
     * @param array $params
     * @return string
     */
    public function parse(string $tag_value, array $params = []): string
    {
        return $this->fetchTwitterEmbed($tag_value);
    }

    /**
     * Returns embeddable tweet
     * @param string $tweet_id
     * @return string
     */
    public function fetchTwitterEmbed(string $tweet_id): string
    {
        $client = new Client();

        $response = $client->get('https://publish.twitter.com/oembed?url=https://twitter.com/erikaheidi/status/' . $tweet_id);
        if ($response['code'] == 200) {
            $body = json_decode($response['body'], true);
            return $body['html'];
        }

        return " [ <a href='https://twitter.com/erikaheidi/status/$tweet_id'>Original Tweet</a> ]";
    }
}
