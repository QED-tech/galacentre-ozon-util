<?php

namespace app\api;

use app\exception\ApiException;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\ResponseInterface;

class Api
{
    /**
     * @var Client
     */
    private $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    public function postRequest(string $url, string $body)
    {
        $headers = [];
        $request = new Request('POST', static::HOST . $url, $headers, $body);
        $response = $this->client->send($request);
        return $this->proccessResponse($response);
    }

    private function proccessResponse(ResponseInterface $response): array
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

    public function getRequest(string $url): array
    {
        $fullUrl = implode('', [static::HOST, $url]);
        $response = $this->client->request('GET', $fullUrl);
        return $this->proccessResponse($response);
    }
}
