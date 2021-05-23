<?php

namespace app;

use Exception;

class GallaParser
{
    /** @var array */
    private $treeCategories;

    public function __construct()
    {
        $treeContent = file_get_contents(__DIR__ . '/../categories.json');
        $this->treeCategories = json_decode($treeContent, true);
    }

    public function findCategoryByKeyword(string $keyword = ''): array
    {
        return array_filter(
            array_map(
                function ($item) use ($keyword) {
                    if (mb_strpos(mb_strtolower($item['title']) ?? '', mb_strtolower($keyword)) !== false) {
                        return $item['category_id'];
                    }
                    if (!empty($item['children'])) {
                        return $this->findCategoryByKeyword($item['children'], $keyword);
                    }
                },
                $this->treeCategories
            )
        );
    }

    public function findCategory(string $keyword = ''): int
    {
        $searchResult = $this->findCategoryByKeyword($keyword);
        if (empty($searchResult)) {
            throw new Exception('Category not found');
        }
        $result = collect($searchResult)->flatten()->values()->all();
        return $result[0];
    }

    public function prepareProductForOzon()
    {
        //TODO Implement function
    }
}
