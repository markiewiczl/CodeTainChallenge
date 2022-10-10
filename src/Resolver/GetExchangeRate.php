<?php

namespace App\Resolver;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class GetExchangeRate implements GetExchangeRateInterface
{
    private HttpClientInterface $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    public function getEuroExchangeRate(): float
    {
            $response = $this->client->request(
                'GET',
                'http://api.nbp.pl/api/exchangerates/rates/a/eur'
            );

        $statusCode = $response->getStatusCode();
        $contentType = $response->getHeaders()['content-type'][0];
        $content = $response->getContent();
        $content = $response->toArray();

        return $content['rates'][0]['mid'];
    }
}