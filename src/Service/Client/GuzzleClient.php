<?php

namespace App\Service\Client;

use GuzzleHttp\Client;

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
            return json_decode($this->client->get($url)->getBody()->getContents());
    }
}
