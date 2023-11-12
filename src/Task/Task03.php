<?php

namespace App\Task;

use App\Service\AidevsHttpClient;
use App\Service\OpenAiClient;
use App\Service\OpenAiRequest\ChatRequest;

class Task03 implements TaskInterface
{
    use TaskTrait;
    private string $taskName = 'blogger';
    private array $logs = [];

    public function __construct(
        private readonly AidevsHttpClient $aidevsHttpClient,
        private readonly OpenAiClient $openAiClient,
    ) {
    }

    public function execute(): void
    {
               
        $token = $this->aidevsHttpClient->retrieveToken($this->taskName);
        $this->logs[] = ['token' => $token];
        
        $task = $this->aidevsHttpClient->retrieveTask($token);
        $this->logs[] = ['task' => $task];

        $answerArray = [];
        foreach ($task['blog'] as $input) {
            $this->logs[] = ['_input_'=> $input];
            
            $chatCompletion = $this->openAiClient->chatCompletions(
                [
                    new ChatRequest('user', $input),
                ],
            );

            //$this->logs[] = ['_result_'=> $chatCompletion];
            $answerArray[] = $chatCompletion[0]['message']['content'];
        }
        
        $this->logs[] = ['_answers_'=> $answerArray];

        // due to timeout retrieve new token
        $token = $this->aidevsHttpClient->retrieveToken($this->taskName);
        $this->logs[] = ['token' => $token];
        $task = $this->aidevsHttpClient->retrieveTask($token);

        $responseAnswer = $this->aidevsHttpClient->sendAnswer($token, $answerArray);
        $this->logs[] = $responseAnswer;
    }
}