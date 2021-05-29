<?php

namespace app\product;

class DishesKitchenUtensils extends AbstractProduct
{
    public const CATEGORY_ID = 14;

    public function getNiceName(): string
    {
        return 'Посуда и кухонные принадлежности';
    }

    public function getProductsByType(array $products): array
    {
        return array_filter($products, function ($product) {
            if (!isset($product['props']) || empty($product['props'])) {
                return false;
            }
            $props = $product['props'];
            $productType = explode('=', $props[0])[1] ?? '';
            return mb_strtolower($productType) === mb_strtolower(static::PRODUCT_TYPE);
        });
    }
}
