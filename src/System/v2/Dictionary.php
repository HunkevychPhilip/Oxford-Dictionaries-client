<?php

namespace App\System\v2;

use App\System\v2\Entity\Entry;
use App\System\Client\ClientException;
use App\System\Client\ClientInterface;
use App\System\v2\Builders\EntriesBuilder;
use Symfony\Component\HttpFoundation\Request;

class Dictionary
{
    /**
     * @var ClientInterface
     */
    private $client;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @param string $lang
     * @param string $word
     *
     * @param Request $request
     * @return Entry[]
     * @throws DictionaryException
     */
    public function entries(string $lang, string $word) : array
    {
        try {
            $data = $this->client->get(sprintf(
                'entries/%s/%s?fields=definitions%%2Cexamples%%2Cpronunciations&strictMatch=false',
                $lang,
                $word
            ));
        } catch (ClientException $e) {
            if ($e->getCode() === 404) {
                header("Location: /?error=404:page_not_found");
                die();
            } else {
                throw new DictionaryException('Something went wrong');
            }
        }

        return (new EntriesBuilder($data))->build();
    }
}
