<?php


namespace App\Repositories;


use App\PublicMask\Api\Clients\SimpleClient;
use App\PublicMask\Api\Result\SaleResult;
use App\PublicMask\Api\Result\StoreResult;

class PublicMaskApiRepository
{
    private $config;

    private $client;

    /**
     * PublicMaskRepository constructor.
     */
    public function __construct(SimpleClient $simpleClient)
    {
        $this->config = config("public-mask");
        $this->client = $simpleClient;
    }

    public function baseUrl()
    {
        return $this->config['base_url'];
    }

    public function apiUrl($key = "")
    {
        $perfectUrl = null;

        $apiList = $this->config['api_list'];

        if (array_key_exists($key, $apiList)) {
            $apiUri = $apiList[$key];
            $perfectUrl = $this->baseUrl() . "/" . $apiUri;
        }

        return $perfectUrl;
    }

    public function getRemoteStores($query = [])
    {
        return $this->client->get($this->apiUrl("stores") . "?" . http_build_query($query));
    }

    public function getStores($query = [])
    {
        $storeResultJson
            = $this->client->get($this->apiUrl("stores") . "?" . http_build_query($query));

        return new StoreResult($storeResultJson);
    }

    public function getRemoteSales($query = [])
    {
        return $this->client->get($this->apiUrl("sales") . "?" . http_build_query($query));
    }

    public function getSales($query = [])
    {
        $saleResultJson
            = $this->client->get($this->apiUrl("sales") . "?" . http_build_query($query));

        return new SaleResult($saleResultJson);
    }

    public function getStoresByGeo()
    {
        return $this->client->get($this->apiUrl("stores_by_geo"));
    }

    public function getStoresByAddress()
    {
        return $this->client->get($this->apiUrl("stores_by_address"));
    }

}
