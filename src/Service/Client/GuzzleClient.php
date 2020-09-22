<?php

namespace App\Service\Client;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class GuzzleClient implements ClientInterface
{
    private $client;

    public function __construct($endpoint, $appId, $appKey)
    {
        $this->client = new Client([
            'base_uri' => $endpoint,
            'headers' => [
                'Accept' => 'application/json',
                'app_id' => $appId,
                'app_key' => $appKey,
            ]
        ]);
    }

    /**
     * @inheritdoc
     */
    public function get(string $url)
    {
        try {
            return json_decode($this->client->get($url)->getBody()->getContents());
        } catch (RequestException $exception) {
            switch ($exception->getCode()) {
                case 404:
                    throw new ClientException('No entry found matching supplied source_lang, word and provided filters.');
                default:
                    throw new ClientException( 'Something went wrong.');
            }
        }
    }
}
