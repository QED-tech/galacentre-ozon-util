<?php

namespace app\product;

class DishesKitchenUtensils extends AbstractProduct
{
    public const CATEGORY_ID = 14;

    public function getNiceName()
    {
        return 'Посуда и кухонные принадлежности';
    }
}
