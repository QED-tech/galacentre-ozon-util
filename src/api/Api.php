<?php

namespace app\api;

use app\exception\ApiException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\ResponseInterface;

class Api
{
    /**
     * @var Client
     */
    private Client $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    private function processResponse(ResponseInterface $response): array
    {
        $json = (string) $response->getBody();
        $result = json_decode($json, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new ApiException("Fail parse response");
        }

        $statusCode = $response->getStatusCode();
        if ($statusCode !== 200) {
            throw new ApiException(sprintf("Runtime error with code %d", $statusCode), $statusCode);
        }

        return is_array($result) ? $result : [];
    }

    /**
     * @throws GuzzleException
     */
    public function getRequest(string $url, array $parameters = []): array
    {
        $fullUrl = implode('', [static::HOST, $url]);
        $response = $this->client->request('GET', $fullUrl);
        return $this->processResponse($response);
    }
}
