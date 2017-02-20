<?php
/**
 * Created by PhpStorm.
 * User: Sergey Trizna
 * Date: 20.02.2017
 * Time: 7:46
 */

namespace BS\Controller;

use BS\Repository\HierarchyRepository;

class HierarchyController extends BaseController
{
    public function buildAction()
    {
        $rep = new HierarchyRepository();
        $structure = $rep->getTree();
        $tree = $this->buildStructure($structure, 0);

        exit(print_r($tree));

    }

    private function buildStructure(array &$structure, $parentId = 0)
    {
        $branch = array();
        foreach ($structure as $item) {
            if ($item['parent_id'] == $parentId) {
                $children = $this->buildStructure($structure, $item['node_id']);
                if ($children) {
                    $item['sub'] = $children;
                }
                $branch[$item['node_id']] = $item;
                unset($structure[$item['node_id']]);
            }
        }
        return $branch;
    }
}