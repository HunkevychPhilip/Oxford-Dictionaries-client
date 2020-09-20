<?php

namespace App\Service;

use App\Service\Client\ClientInterface;
use App\Service\ResponseHandler\EntriesBuilder;
use App\Entity\Entry;
use GuzzleHttp\Exception\ClientException;

class Dictionary
{
    private $client;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @param string $lang
     * @param string $word
     *
     * @return Entry[]
     * @throws ClientException
     */
    public function entries(string $lang, string $word) : array
    {
            $data = $this->client->get(sprintf(
                'entries/%s/%s?fields=definitions%%2Cexamples%%2Cpronunciations&strictMatch=false',
                $lang,
                $word
            ));

        return (new EntriesBuilder($data))->build();
    }
}
