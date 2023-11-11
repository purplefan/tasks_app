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
    
    public function retrieveTask(string $taskToken): array
    {
        $responseData = $this->client->request(
            'GET',
            sprintf('https://zadania.aidevs.pl/task/%s', $taskToken),
        );

        $statusCode = $responseData->getStatusCode();

        if ($statusCode != 200) {
            throw new RuntimeException(sprintf('Client returned error %d', $statusCode));
        }

        $contentArray = $responseData->toArray();

        return $contentArray;
    }

    public function retrieveTaskWithParams(string $taskToken, array $taskParams): array
    {
        $responseData = $this->client->request(
            'POST',
            sprintf('https://zadania.aidevs.pl/task/%s', $taskToken),
            [
                'body' => $taskParams,
            ],
        );

        $statusCode = $responseData->getStatusCode();

        if ($statusCode != 200) {
            throw new RuntimeException(sprintf('Client returned error %d', $statusCode));
        }

        $contentArray = $responseData->toArray();

        return $contentArray;
    }
    
    public function sendAnswer(string $token, string|array $answer): array
    {
        $responseAnswer = $this->client->request(
            'POST',
            sprintf('https://zadania.aidevs.pl/answer/%s', $token),
            [
                'json' => ['answer' => $answer],
            ],
        );

        $statusCode = $responseAnswer->getStatusCode();
        

        if ($statusCode != 200) {
            //throw new RuntimeException(sprintf('Client returned error %d', $statusCode));
        }

        $contentArray = $responseAnswer->toArray(false);

        return $contentArray;
    }
}
