<?php

namespace App\Service;

use \RuntimeException;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class AidevsHttpClient
{
    
    public function __construct(
        private readonly HttpClientInterface $client,
        private readonly string              $apiToken,
    ) {
        
    }

    public function retrieveToken(string $taskName): string
    {
        $responseToken = $this->client->request(
            'POST',
            sprintf('https://zadania.aidevs.pl/token/%s', $taskName),
            [
                'json' => ['apikey' => $this->apiToken],
            ],
        );

        $statusCode = $responseToken->getStatusCode();
        
        if ($statusCode != 200) {
            throw new RuntimeException(sprintf('Client returned error %d', $statusCode));
        }
        
        $contentArray = $responseToken->toArray();
        
        return $contentArray['token'];
    }
    
    public function retrieveTask(string $taskToken): string
    {
        $responseData = $this->client->request(
            'GET',
            sprintf('https://zadania.aidevs.pl/task/%s', $taskToken),
            [
                'json' => ['apikey' => $this->apiToken],
            ],
        );

        $statusCode = $responseData->getStatusCode();

        if ($statusCode != 200) {
            throw new RuntimeException(sprintf('Client returned error %d', $statusCode));
        }

        $contentArray = $responseData->toArray();

        return $contentArray['cookie'];
    }
    
    public function sendAnswer(string $token, string $answer): array
    {
        $responsAnswer = $this->client->request(
            'POST',
            sprintf('https://zadania.aidevs.pl/answer/%s', $token),
            [
                'json' => ['answer' => $answer],
            ],
        );

        $statusCode = $responsAnswer->getStatusCode();

        if ($statusCode != 200) {
            throw new RuntimeException(sprintf('Client returned error %d', $statusCode));
        }

        $contentArray = $responsAnswer->toArray();

        return $contentArray;
    }
}
