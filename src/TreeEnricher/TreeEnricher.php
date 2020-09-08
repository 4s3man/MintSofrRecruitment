<?php

namespace App\TreeEnricher;

class TreeEnricher
{
    const CHILDREN_LABEL = 'children';

    private ListData $listData;

    public function __construct(array $listData)
    {
        $this->listData = new ListData($listData);
    }

    public function enrichTree(array $tree): array
    {
        $this->walk($tree);

        return $tree;
    }

    private function walk(&$data)
    {
        foreach ($data as $key => &$item) {
            $id = $item['id'] ?? null;
            $name = $this->listData->getNameById($id);
            if ($name) {
                $item['name'] = $name;
            }

            if ($this->nodeHasChildren($item)) {
                $this->walk($item[self::CHILDREN_LABEL]);
            }
        }
    }

    private function nodeHasChildren($node): bool
    {
        return 0 !== count($node[self::CHILDREN_LABEL] ?? []);
    }
}
