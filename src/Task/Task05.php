<?php

namespace App\Task;

use App\Service\AidevsHttpClient;
use App\Service\OpenAiClient;
use App\Service\OpenAiRequest\ChatRequest;

class Task05 implements TaskInterface
{
    use TaskTrait;
    
    private string $taskName = 'inprompt';
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
        $this->logs[] = ['task' => $task['question']];

        $test = $this->openAiClient->chatCompletions(
            [
                new ChatRequest('system','Pytanie zawiera imię. Nie odpowiadaj na pytanie, tylko Zwróć to imię'),
                new ChatRequest('user', $task['question']),
            ],
        );

        $name = $test[0]['message']['content'];

        $this->logs[] = ['imie' => $name];

        $input = $task['input'];

        $filtred = array_values(array_filter($input, function ($statement) use ($name) {
            return str_contains($statement, $name);
        }));

        $this->logs[] = ['filtred' => $filtred];
        

        $chatAnswer = $this->openAiClient->chatCompletions(
            [
                new ChatRequest('system', sprintf('Wszystkie potrzebne informacje są tu: %s. odpowiedz na pytanie.', implode(', ', $filtred))),
                new ChatRequest('user', $task['question']),
            ],
        );


        $answerArray = $answerArray[] = $chatAnswer[0]['message']['content'];;
        $this->logs[] = ['_answers_'=> $answerArray];


        $responseAnswer = $this->aidevsHttpClient->sendAnswer($token, $answerArray);
        $this->logs[] = $responseAnswer;
    }
}