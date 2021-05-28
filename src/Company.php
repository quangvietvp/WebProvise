<?php
namespace WebProvise;

use WebProvise\Travel;

class Company
{
    public $endPoint;
    public $data;
    public $travel;

    public function __construct()
    {
        $this->endPoint = 'https://5f27781bf5d27e001612e057.mockapi.io/webprovise/companies';
        $data = file_get_contents($this->endPoint);
        $this->data = json_decode($data, true);
        $this->travel = new Travel();
    }

    /**
     * Generate company tree
     * @param Array $input
     * @param String $pid
     * @return Array
     */
    public function buildCompanyTreeData($input, $pid = 0): array
    {
        $returnData = array();
        foreach ($input as $key => $value) {
            if ($pid == $value['parentId']) {
                $tmpArr = [
                    'id' => $value['id'],
                    'name' => $value['name'],
                    'cost' => $this->travel->getTravelCostByCompany($value['id']),
                ];
                $value['cost'] = $this->travel->getTravelCostByCompany($value['id']);
                unset($value['createdAt']);
                unset($value['parentId']);

                // Get children
                unset($input[$key]); // Remove item which already handle
                $children = $this->buildCompanyTreeData($input, $value['id']);
                $childrenCost = 0;
                if (!empty($children)) {
                    foreach ($children as $k => $v) {
                        unset($children[$k]['createdAt']);
                        unset($children[$k]['parentId']);
                        $children[$k]['cost'] = $this->travel->getTravelCostByCompany($v['id']);
                        $childrenCost += $children[$k]['cost'];
                    }
                }
                $value['cost'] += $childrenCost;
                $value['children'] = $children;
                array_push($returnData, $value);
            }
        }
        return $returnData;
    }
}
