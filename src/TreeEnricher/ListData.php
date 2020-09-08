<?php

namespace App\TreeEnricher;

use IteratorAggregate;

class ListData implements IteratorAggregate
{
    private array $nameById = [];

    public function __construct(array $listData)
    {
        $this->nameById = array_reduce(
            $listData,
        function (array $carry, $item) {
            $id = $item['category_id'] ?? null;
            $name = $item['translations']['pl_PL']['name'] ?? null;
            if ($id && $name) {
                $carry[$id] = $name;
            }

            return $carry;
        }, []);
    }

    public function getNameById(?string $id): ?string
    {
        return $this->nameById[$id] ?? null;
    }

    public function getIterator(): iterable
    {
        return $this->nameById;
    }
}
