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
    private $fields;
    private $strictMatch;
    private $client;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @param string $word
     */
    public function setWord(string $word): void
    {
        $this->word = strtolower($word);
    }

    /**
     * @param string $language
     */
    public function setLanguage(string $language): void
    {
        $this->language = $language;
    }

    /**
     * @param array $fields
     */
    public function setFields(array $fields): void
    {
        $result = 'fields=' . implode(",", $fields);
        $this->fields = $result;
    }

    /**
     * @param boolean $bool
     */
    public function setStrictMatch(bool $bool): void
    {
        $this->strictMatch = $bool;
    }

    /**
     * @return string
     */
    public function getWord(): string
    {
        return $this->word;
    }

    /**
     * @return string
     */
    public function getLanguage(): string
    {
        return $this->language;
    }

    /**
     * @return string
     */
    public function getFields(): string
    {
        return $this->fields;
    }

    /**
     * @return bool
     */
    public function getStrictMatch(): bool
    {
        return $this->strictMatch;
    }

    /**
     * @return Entry[]
     * @throws DictionaryException
     */
    public function entries(): array
    {
        try {
            $path = sprintf('%s/%s?%s&%s',
                $this->language,
                $this->word,
                $this->fields,
                $this->strictMatch);
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
