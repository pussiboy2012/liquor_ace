<?php

require 'vendor/autoload.php';

// You have to use VPN to deal with GPT
$client = OpenAI::client('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');

// Transcribing audio
$response = $client->audio()->transcribe([
    'model' => 'whisper-1',
    'file' => fopen('cooking.mp3', 'r'),
    'response_format' => 'verbose_json',
]);

$rawText = $response->text;

//$text = file_get_contents('text.txt'); // Text converting test

// Formating text in markdown
$result = $client->chat()->create([
    'model' => 'gpt-3.5-turbo-0125',
    'messages' => [
        ['role' => 'user', 'content' => "Проанализируй следующий текст и оформи его в markdown: $rawText"],
    ],
]);

$formatedText = $result->choices[0]->message->content;

// Converting markdown to html
$Parsedown = new Parsedown();
echo $Parsedown->text($formatedText);