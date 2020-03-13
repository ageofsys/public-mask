<?php


namespace App\PublicMask\Api\Result;


use App\MaskSyncErrorLog;
use App\PublicMask\Api\Exceptions\NotExistsRemoteModelAttribute;
use App\PublicMask\Api\StoreParser;
use App\PublicMask\Api\Sync\Sync;
use App\PublicMask\StoreSync;

class StoreResult
{
    public $totalPages;
    public $totalCount;
    public $page;
    public $count;
    public $stores;

    public function __construct($rawJson)
    {
        $this->totalPages = $rawJson["totalPages"];
        $this->totalCount = $rawJson["totalCount"];
        $this->page = $rawJson["page"];
        $this->count = $rawJson["count"];

        echo "### " . $rawJson["page"] . " 페이지" . PHP_EOL;
        echo "항목 갯수 (count) : " . count($rawJson["storeInfos"]) . PHP_EOL;
        echo "항목 갯수 : " . $rawJson["count"] . PHP_EOL;
        echo "페이지 갯수 : " . $rawJson["totalPages"] . PHP_EOL;
        echo "전체 갯수 : " . $rawJson["totalCount"] . PHP_EOL;


        $stores = [];
        foreach ($rawJson["storeInfos"] as $storeJson) {
            $storeParser = new StoreParser($storeJson);

            try {
                $store = $storeParser->parse();

                if ($store) {
                    $stores[] = $store;
                }

                $this->stores = $stores;
            } catch (NotExistsRemoteModelAttribute $exception) {
                StoreSync::$maskSyncLog->errors()->save(
                    new MaskSyncErrorLog([
                        "title" => $exception->getMessage(),
                        "content" => ""
                    ])
                );
            } catch (\Exception $exception) {
                var_dump($exception->getMessage());
            }

        }


    }
}
