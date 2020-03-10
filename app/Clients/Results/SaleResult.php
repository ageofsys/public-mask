<?php


namespace App\Clients;


use App\PublicMask\Sale;
use App\PublicMask\Store;

class SaleResult
{
    public $totalPages;
    public $totalCount;
    public $page;
    public $count;
    public $sales;

    public function __construct($json)
    {
        $this->totalPages = $json["totalPages"];
        $this->totalCount = $json["totalCount"];
        $this->page = $json["page"];
        $this->count = $json["count"];

        $sales = [];
        foreach ($json["sales"] as $saleJson) {
            $sales[] = new Sale($saleJson);
        }

        $this->sales = $sales;
    }

}
