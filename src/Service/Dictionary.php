<?php

namespace App\Service;

use App\Service\Client\ClientInterface;
use App\Service\Client\ClientException;
use App\Service\ResponseHandler\EntriesBuilder;
use App\Entity\Entry;

class Dictionary
{
    private $word;
    private $language;
    private $client;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @return string
     */
    public function getWord() : string
    {
        return $this->word;
    }

    /**
     * @param string $word
     */
    public function setWord($word): void
    {
        $this->word = strtolower($word);
    }

    /**
     * @return string
     */
    public function getLanguage() : string
    {
        return $this->language;
    }

    /**
     * @param string $language
     */
    public function setLanguage($language): void
    {
        $this->language = $language;
    }

    /**
     * @param string $lang
     * @param string $word
     *
     * @return Entry[]
     * @throws DictionaryException
     */
    public function entries() : array
    {
        try {
            $path = sprintf('%s/%s', $this->language, $this->word);
            $response = $this->client->get($path);
        } catch (ClientException $exception) {
            switch ($exception->getCode()) {
                case 404:
                    $data = null;
                    break;
                default:
                    throw new DictionaryException($exception->getMessage());
            }
        }

        return (new EntriesBuilder($response))->build();
    }
}
