<?php

declare(strict_types=1);

namespace Avature\Utils;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Response;

class HttpRequest
{
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function get($url, $options = []): ?Response
    {
        try {
            return $this->client->request('GET', $url, $options);
        } catch (RequestException $e) {
            return null;
        }
    }

    public function post($url, $options = []): ?Response
    {
        try {
            return $this->client->request('post', $url, $options);
        } catch (RequestException $e) {
            return null;
        }
    }
}
