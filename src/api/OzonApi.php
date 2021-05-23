<?php

namespace app\api;

use Gam6itko\OzonSeller\Service\V1\CategoriesService;
use GuzzleHttp\Client as GuzzleClient;
use Http\Adapter\Guzzle6\Client as GuzzleAdapter;

class OzonApi extends Api
{
    public const HOST = 'https://api-seller.ozon.ru/';

    public function getAttributes(int $id, $config)
    {
        $adapter = new GuzzleAdapter(new GuzzleClient());
        $svc = new CategoriesService($config, $adapter);
        return $svc->attributes($id);
    }
}
