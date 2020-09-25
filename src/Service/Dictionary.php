<?php

namespace App\Service;

use App\Service\Client\ClientInterface;
use App\Service\Client\ClientException;
use App\Service\ResponseHandler\EntriesBuilder;
use App\Entity\Entry;

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
     *
     * @throws DictionaryException
     */
    public function entries(string $lang, string $word) : array
    {
        try {
            $endURL = sprintf('%s/%s', $lang, $word);
            $data = $this->client->get($endURL);
        } catch (ClientException $exception) {
            switch ($exception->getCode()) {
                case 404:
                    $data = null;
                    break;
                default:
                    throw new DictionaryException($exception->getMessage());
            }
        }

        return (new EntriesBuilder($data))->build();
    }
}
