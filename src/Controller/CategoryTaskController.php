<?php

namespace App\Controller;

use App\TreeEnricher\ListData;
use App\TreeEnricher\TreeEnricher;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CategoryTaskController extends AbstractController
{
    /**
     * @Route("/category-task", name="category_task")
     */
    public function index(string $treeJsonPath, string $listJsonPath)
    {
        $treeData = json_decode(file_get_contents($treeJsonPath), true);
        $listData = json_decode(file_get_contents($listJsonPath), true);

        $enrichedTree = (new TreeEnricher($listData))->enrichTree($treeData);

        return $this->render('category_task/index.html.twig', [
            'treeJson' => $treeData,
            'listJson' => $listData,
            'nameById' => (new ListData($listData))->getIterator(),
            'enrichedTreeJson' => $enrichedTree,
        ]);
    }
}
