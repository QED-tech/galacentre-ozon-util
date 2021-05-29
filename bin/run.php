#!/usr/bin/php
<?php

use app\api\GalacentreApi;
use app\product\KitchenKnife;

use function app\addProductsOzon;
use function app\errorLog;
use function app\logger;

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

$galacentreApi = new GalacentreApi();
$rawData = $galacentreApi->getRequest("catalog/json/?key=$galaKey&section=14&store=nsk&active=Y");

$data = $rawData['DATA'] ?? [];
$resultProducts = getProductsForImport($data);

//$tasks = addProductsOzon($resultProducts, $config);

function getProductsForImport(array $data): array
{
    $knifeModel = new KitchenKnife();
    $onlyKnifeses = $knifeModel->getProductsByType($data);
    $result = [];
    foreach ($onlyKnifeses as $knife) {
        try {
            $preparedProduct = $knifeModel->prepareForOzon($knife);
            $result[] = $preparedProduct;
            logger($preparedProduct, 'preparedProduct');
        } catch (Throwable $e) {
            errorLog($e->getMessage());
            continue;
        }
    }
    return $result;
}
