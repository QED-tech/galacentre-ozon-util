#!/usr/bin/php
<?php

use function app\addProductsOzon;
use function app\getExample;

require __DIR__ . '/../vendor/autoload.php';

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

$product = json_decode(getExample(), true);
ksort($product, SORT_STRING);

$config = [
    'clientId' => $ozonClientId,
    'apiKey' => $ozonApiKey,
];

addProductsOzon($product, $config);