<?php


namespace App\Clients;




use App\PublicMask\Store;
use Illuminate\Pagination\Paginator;

class StoreResult
{
    public $totalPages;
    public $totalCount;
    public $page;
    public $count;
    public $storeInfos;

    /**
     * StoreResult constructor.
     * @param $json
     */
    public function __construct($json)
    {
        $this->totalPages = $json["totalPages"];
        $this->totalCount = $json["totalCount"];
        $this->page = $json["page"];
        $this->count = $json["count"];

        $stores = [];
        foreach ($json["storeInfos"] as $storeJson) {
            $stores[] = new Store($storeJson);
        }

        $this->storeInfos = $stores;
    }

}
