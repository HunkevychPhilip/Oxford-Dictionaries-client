<?php

namespace App\System\Client;

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
