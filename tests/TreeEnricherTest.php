<?php

namespace App\Tests;

use App\TreeEnricher\ListData;
use App\TreeEnricher\TreeEnricher;
use PHPUnit\Framework\TestCase;

class TreeEnricherTest extends TestCase
{
    private $fixturesDir = __DIR__.'/fixtures/';

    public function testTreeEnriching()
    {
        $rawListData = json_decode(file_get_contents($this->fixturesDir.'list.json'), true);
        $rawTreeData = json_decode(file_get_contents($this->fixturesDir.'tree.json'), true);

        $enrichedTree = (new TreeEnricher($rawListData))->enrichTree($rawTreeData);
        $listData = new ListData($rawListData);

        $this->assertTrue($this->areNamesAdded($enrichedTree, $listData));

        foreach ($enrichedTree as &$item) {
            unset($item['name']);
        }

        $this->assertFalse($this->areNamesAdded($enrichedTree, $listData));
    }

    public function areNamesAdded(array $enrichedTree, $listData): bool
    {
        foreach ($this->generateTreeItems($enrichedTree) as $data) {
            $foundName = $listData->getNameById($data['id']);
            $currentName = $data['name'] ?? null;

            if ($foundName !== $currentName) {
                return false;
            }
        }

        return true;
    }

    private function generateTreeItems($data): iterable
    {
        foreach ($data as $key => $item) {
            yield $item;
            $children = $item['children'] ?? [];

            if (0 !== count($children)) {
                yield from $this->generateTreeItems($item['children']);
            }
        }
    }
}
