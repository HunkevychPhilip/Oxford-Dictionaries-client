<?php

namespace App\Service\Client;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;

class GuzzleClient implements ClientInterface
{
    private $client;

    public function __construct(string $endpoint, string $appId, string $appKey)
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
     * @param string $url
     * @return array|mixed
     * @throws ClientException|GuzzleException
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
