<?php

namespace app;

use Gam6itko\OzonSeller\Service\V1\ProductService;
use GuzzleHttp\Client as GuzzleClient;
use Http\Adapter\Guzzle6\Client as GuzzleAdapter;
use Monolog\Formatter\JsonFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

function logger(array $record): void
{
    $logger = new Logger('MyLogger');
    $handler = new StreamHandler(__DIR__ . '/../log/products' . time() . '.txt', Logger::INFO);
    $logger->pushHandler($handler);
    $formatter = new JsonFormatter();
    $logger->info($formatter->format($record));
}

function getExample(): string
{
    return <<<JSON
    {"id":"507WRAD","active":"N","date_update":"1621313191","articul":"475-123","name":"LEBEN Чайник электрический 1,8л, 1850Вт, скрытый нагр.элемент, пластик, HHB1760","about":"Электрочайник это один из самых популярных видов современных электрических бытовых приборов, который предназначен для подогрева воды. LEBEN предлагает богатый выбор чайников с разнообразным дизайном, разных цветовых исполнений и ценовых уровней.","section":"5289","image":"https://image.galacentre.ru/507WRAD.jpg","images":["https://image.galacentre.ru/size/1000/507WRAD-1.jpg","https://image.galacentre.ru/size/1000/507WRAD-2.jpg","https://image.galacentre.ru/size/1000/507WRAD-3.jpg"],"price_base":853.13,"price_old":0,"price_sp":0,"price_ind":0,"min":"1","box":"8","fix":"0","new":"0","hit":"0","brand":"LEBEN","store_ekb":"2","store_msk":"2","store_nsk":"0","store_vld":"2","way":"03.07.2021","sert":["https://www.galacentre.ru/sert/RUS-CN.VE02.V.01895_20.jpg","https://www.galacentre.ru/sert/RUS-CN.VE02.V.01895_20(2).jpg","https://www.galacentre.ru/sert/RUS-CN.VE02.V.01895_20(3).jpg","https://www.galacentre.ru/sert/RUS-CN.VE02.V.01895_20(4).jpg","https://www.galacentre.ru/sert/RUD-CN.AJa46.V.14663_20.jpg","https://www.galacentre.ru/sert/RUD-CN.AJa46.V.14663_20(2).jpg"],"barcode":"4680259217129","marked":0,"props":["Тип товара=чайник электрический","Бренд=LEBEN"],"specifications":["Страна производитель=Китай","Материал=пластик","Объем=1,8 л","Цвет=Белый с черным","Мощность=1850 Вт","Напряжение=220-240 В","Длина сетевого шнура=75 см","Тип нагревательного элемента=скрытый","Индикация=Индикация работы, индикатор уровня воды, блокировка включения без воды","Функции=Отключение при закипании, отключение при снятии, отключение при отсутствии воды","Время закипания=5,5 мин","Режим работы=Кипячение","Особенности=Толщина корпуса - 2 мм","Вес в упаковке=0,94 кг","Размер упаковки=20,1x16,4x22,1 см"],"includes":[]}
    JSON;
}

function addProductsOzon(array $product, array $config): array
{
    $adapter = new GuzzleAdapter(new GuzzleClient());
    $svcProduct = new ProductService($config, $adapter);
    return $svcProduct->import($product);
}
