<?php
namespace WebProvise;

class Travel
{
    public $endPoint;
    public $data;

    public function __construct()
    {
        $this->endPoint = 'https://5f27781bf5d27e001612e057.mockapi.io/webprovise/travels';
        $data = file_get_contents($this->endPoint);
        $this->data = json_decode($data, true);
    }

    public function getTravelCostByCompany($companyId): int
    {
        $cost = 0;
        foreach ($this->data as $value) {
            if ($companyId == $value['companyId']) {
                $cost += $value['price'];
            }
        }
        return $cost;
    }
}
