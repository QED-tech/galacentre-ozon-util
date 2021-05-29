<?php

namespace app\product;

class KitchenKnife extends DishesKitchenUtensils
{
    public const PRODUCT_TYPE = 'Нож кухонный';
    public const OZON_CATEGORY_ID = 17032245;

    public function getProductsByType(array $products): array
    {
        return parent::getProductsByType($products);
    }

    public function prepareForOzon(array $product): array
    {
        $price = $product['price_base'] + (($product['price_base'] / 100) * 20);
        if ((int) $price < 49) {
            $price = 70;
        }

        //TODO Implement getPrice function
        $oldPrice = $price + (($price / 100) * 10);
        $premiumPrice = $price - (($price / 100) * 10);
        //TODO Implement getDescription function
        $description = $product['about'] === '' ? $product['name'] : $product['about'];

        return [
            'barcode' => (string) $product['barcode'],
            'description' => $description,
            'category_id' => self::OZON_CATEGORY_ID,
            'name' => $product['name'],
            'offer_id' => (string) $product['articul'],
            'price' => (string) $price,
            'old_price' => (string) round($oldPrice, 0, PHP_ROUND_HALF_DOWN),
            'premium_price' => (string) round($premiumPrice, 0, PHP_ROUND_HALF_DOWN),
            'vendor' => $product['brand'],
            'vendor_code' => $product['id'],
            'vat' => '0',
            'height' => 280,
            'depth' => 50,
            'width' => 50,
            'dimension_unit' => 'mm',
            'weight' => 88,
            'weight_unit' => 'g',
            'images' => $this->getImages($product),
            'attributes' => $this->getAttributes($product)
        ];
    }

    private function getAttributes(array $product): array
    {
        return [
            [
                'id' => 6730,
                'collection' => ['2', '11'],
            ],
            [
                'id' => 6731,
                'value' => $this->getBladeLength($product),
            ],
            [
                'id' => 6733,
                'collection' => ['114', '329'],
            ],

            [
                'id' => 8229,
                'collection' => ['1633'],
            ],
            [
                'id' => 9048,
                'value' => $product['name'],
            ],
        ];
        //6730 - Назначение
        //6731 - Макс. длина лезвия, см
        //6733 - Материал рукояти
        //8229 - Тип
        //9048 - Укажите название модели товара. Не указывайте в этом поле тип и бренд.
    }

    private function getImages(array $product): array
    {
        return [
            [
                'file_name' => $product['images'][0],
                'default' => true,
            ],
            [
                'file_name' => $product['image'],
                'default' => false,
            ]
        ];
    }

    private function getBladeLength(array $product): string
    {
        $specifications = $this->getSpecifications($product);
        foreach ($specifications as $specification) {
            $specParts = explode($specification, '=');
            if (count($specParts) === 2 && $specParts[0] === 'Длина лезвия') {
                return (string) $specParts[1];
            }
        }
        return '12,7';
    }

    private function getPrice(): array
    {
        return [];
    }

    private function getSpecifications(array $product): array
    {
        return $product['specifications'];
    }

    public function getCategoryAttributes(int $id, bool $onlyRequired = false): array
    {
        return [];
    }
}
