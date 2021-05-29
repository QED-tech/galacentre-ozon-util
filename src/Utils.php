<?php

namespace app;

use Gam6itko\OzonSeller\Service\V1\ProductService;
use GuzzleHttp\Client as GuzzleClient;
use Http\Adapter\Guzzle6\Client as GuzzleAdapter;
use Monolog\Formatter\JsonFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

function logger(array $record, string $logCategory = 'products', string $extension = 'log'): void
{
    $logger = new Logger('MyLogger');
    $handler = new StreamHandler(__DIR__ . '/../log/' . $logCategory . '.' . $extension, Logger::INFO);
    $logger->pushHandler($handler);
    $formatter = new JsonFormatter();
    $logger->info($formatter->format($record));
}

function errorLog(string $record): void
{
    $logger = new Logger('MyLogger');
    $handler = new StreamHandler(__DIR__ . '/../log/products-error.log', Logger::ERROR);
    $logger->pushHandler($handler);
    $logger->error($record);
}

function addProductsOzon(array $product, array $config): array
{
    $adapter = new GuzzleAdapter(new GuzzleClient());
    $svcProduct = new ProductService($config, $adapter);
    return $svcProduct->import($product);
}
