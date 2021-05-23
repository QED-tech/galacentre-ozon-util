#!/usr/bin/php
<?php

require __DIR__ . '/../vendor/autoload.php';

/********* Initial *********/

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$galaKey = $_ENV['galaKey'] ?? '';
$ozonClientId = $_ENV['ozonClientId'] ?? '';
$ozonApiKey = $_ENV['ozonKey'] ?? '';

foreach ([$galaKey, $ozonApiKey, $ozonClientId] as $key) {
    if ($key === '') {
        throw new Exception('Key is not set');
    }
}

$config = [
    'clientId' => $ozonClientId,
    'apiKey' => $ozonApiKey,
];

/********* *********/
