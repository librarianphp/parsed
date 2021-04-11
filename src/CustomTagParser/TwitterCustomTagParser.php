<?php


namespace Parsed\CustomTagParser;

use Parsed\CustomTagParserInterface;
use Minicli\Curly\Client;

class TwitterCustomTagParser implements CustomTagParserInterface
{
    /**
     * @param $tag_value
     * @param array $params
     * @return string
     */
    public function parse($tag_value, array $params = [])
    {
        return $this->fetchTwitterEmbed($tag_value);
    }

    /**
     * Returns embeddable tweet
     * @param $tweet_id
     * @return string
     */
    public function fetchTwitterEmbed($tweet_id)
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