<?php

declare(strict_types=1);

namespace App\Service;

use App\Service\OpenAiRequest\ChatRequest;
use OpenAI;

class OpenAiClient
{
    private OpenAI\Client $openAiClient;

    public function __construct(
        private string $apiToken,
    ) {
        $this->openAiClient = OpenAI::client($this->apiToken);
    }

    /**
     * @var ChatRequest[] $chatRequests
     */
    public function chatCompletions(array $chatRequests, OpenAiModel $openAiModel = OpenAiModel::GPT_35_TURBO): array
    {
        $messages = [];
        foreach ($chatRequests as $chatRequest) {
            $messages[] = ['role' => $chatRequest->role, 'content'=> $chatRequest->content];
        }

        $result = $this->openAiClient->chat()->create([
            'model' => $openAiModel->value,
            'messages' => $messages,
        ]);

        return $result['choices'];
    }

    public function moderations(string|array $input): array
    {
        
        $result = $this->openAiClient->moderations()->create([
            'input' => $input,
        ]);

        return $result['results'];
    }

    public function embeddings(string $input): array
    {
        
        $result = $this->openAiClient->embeddings()->create([
            'input' => $input,
            'model' => OpenAiModel::TEXT_EMBEDDING->value,
        ]);

        return $result['data'][0]['embedding'];
    }
}
