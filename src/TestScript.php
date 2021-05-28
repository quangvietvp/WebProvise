<?php
namespace WebProvise;

use WebProvise\Company;

class TestScript
{
    public function execute()
    {
        $start = microtime(true);
        $company = new Company();
        $result = $company->buildCompanyTreeData($company->data);

        echo json_encode($result);
        echo 'Total time: '.  (microtime(true) - $start);
    }
}
