<?php

namespace app\product;

class KitchenKnife extends DishesKitchenUtensils
{
    public const PRODUCT_TYPE = 'Нож кухонный';
    public const OZON_CATEGORY_ID = 17032245;

    public function getProducts(array $data): array
    {

        return [];
    }

    public function getCategoryAttributes(int $id, bool $onlyRequired = false): array
    {

        return [];
    }
}
