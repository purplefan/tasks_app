<?php

namespace App\Task;

use App\Service\AidevsHttpClient;
use App\Service\OpenAiClient;
use App\Service\OpenAiRequest\ChatRequest;

class Task04 implements TaskInterface
{
    private string $taskName = 'liar';
    private array $logs = [];

    public function __construct(
        private readonly AidevsHttpClient $aidevsHttpClient,
        private readonly OpenAiClient $openAiClient,
    ) {
    }
    
    public function taskName(): string
    {
        return $this->taskName;
    }

    public function execute(): void
    {
               
        $token = $this->aidevsHttpClient->retrieveToken($this->taskName);
        $this->logs[] = ['token' => $token];

        $question = 'What is the name of the president of USA';

        $params = ['question' => $question];
        $task = $this->aidevsHttpClient->retrieveTaskWithParams($token, $params);
        $this->logs[] = ['task' => $task];

        //guardrails
        $testedAnswer = $task['answer'];
        $testedStatement = sprintf('For question: "%s" is the answer this: "%s"', $question, $testedAnswer);
        $test = $this->openAiClient->chatCompletions(
            [
                new ChatRequest('system','Answer only YES or NO'),
                new ChatRequest('user', $testedStatement),
            ],
        );

        $this->logs[] = $test;


        $answerArray = $answerArray[] = $test[0]['message']['content'];;
        
        $this->logs[] = ['_answers_'=> $answerArray];


        $responseAnswer = $this->aidevsHttpClient->sendAnswer($token, $answerArray);
        $this->logs[] = $responseAnswer;
    }
    
    public function logs(): string
    {
        return json_encode($this->logs, JSON_PRETTY_PRINT);
    }
}