<?php

namespace app\product;

abstract class AbstractProduct
{
    abstract public function getProductsByType(array $products): array;
}
