<?php


namespace App\PublicMask\Api\Result;


use App\MaskSyncErrorLog;
use App\PublicMask\Api\Exceptions\NotExistsRemoteModelAttribute;
use App\PublicMask\Api\SaleParser;
use App\PublicMask\Api\StoreParser;
use App\PublicMask\SaleSync;

class SaleResult
{
    public $totalPages;
    public $totalCount;
    public $page;
    public $count;
    public $sales;

    public function __construct($rawJson)
    {
        $this->totalPages = $rawJson["totalPages"];
        $this->totalCount = $rawJson["totalCount"];
        $this->page = $rawJson["page"];
        $this->count = $rawJson["count"];

        echo "### " . $rawJson["page"] . " 페이지" . PHP_EOL;
        echo "항목 갯수 (count) : " . count($rawJson["sales"]) . PHP_EOL;
        echo "항목 갯수 : " . $rawJson["count"] . PHP_EOL;
        echo "페이지 갯수 : " . $rawJson["totalPages"] . PHP_EOL;
        echo "전체 갯수 : " . $rawJson["totalCount"] . PHP_EOL;


        $sales = [];
        foreach ($rawJson["sales"] as $saleJson) {
            $saleParser = new SaleParser($saleJson);

            try {
                $sale = $saleParser->parse();

                if ($sale) {
                    $sales[] = $sale;
                }

                $this->sales = $sales;
            } catch (NotExistsRemoteModelAttribute $exception) {
                SaleSync::$maskSyncLog->errors()->save(
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
