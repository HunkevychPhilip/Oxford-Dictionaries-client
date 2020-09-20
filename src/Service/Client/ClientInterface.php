<?php

namespace App\Service\Client;

interface ClientInterface
{
    /**
     * @param  string  $url
     *
     * @return array
     * @throws ClientException
     */
    public function get(string $url);
}
