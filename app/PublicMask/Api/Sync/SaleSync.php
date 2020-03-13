<?php


namespace App\PublicMask;


use App\MaskSyncErrorLog;
use App\MaskSyncLog;
use App\PublicMask\Api\Result\SaleResult;
use App\Repositories\PublicMaskApiRepository;
use App\Sale;
use Illuminate\Support\Facades\DB;

class SaleSync
{
    private $repository;

    public static $maskSyncLog;

    public $localSales;

    public function __construct(PublicMaskApiRepository $publicMaskApiRepository)
    {
        $this->repository = $publicMaskApiRepository;

//        $this->localSales = Sale::all();
    }

    public function sync()
    {
        // 페이지 번호
        $currentPage = 1;

        // 총 페이지 갯수
        $totalPages = null;

        try {

            do {

                $requestParameter = ["page" => $currentPage, "perPage" => 5000];

                self::$maskSyncLog = $maskSync = MaskSyncLog::create([
                    "target" => "sale",
                    "request_params" => collect($requestParameter)->toJson(),
                    "sync_started_at" => now()
                ]);

                $rawSaleResult = $this->repository->getRemoteSales($requestParameter);

                $maskSync->remote_total_count = $rawSaleResult["totalCount"];

                $saleResult = new SaleResult($rawSaleResult);

                $this->saveMany($saleResult->sales);

                if ($totalPages == null) {
                    $totalPages = $saleResult->totalPages;
                }

                $maskSync->succeed = true;
                $maskSync->sync_ended_at = now();
                $maskSync->save();

            } while (++$currentPage <= $totalPages);

        }
        catch (\Exception $exception) {

            self::$maskSyncLog->succeed = false;
            self::$maskSyncLog->sync_ended_at = now();
            self::$maskSyncLog->save();

            self::$maskSyncLog->errors()->save(
                new MaskSyncErrorLog(["title" => $exception->getMessage(), "content" => "" ])
            );

            dd($exception);

        }



    }

    public function saveMany($sales)
    {
        foreach ($sales as $sale) {
            $this->saveOne($sale);
        }
    }

    public function saveOne($sale)
    {
        $sale->mask_sync_log_id = self::$maskSyncLog->id;
        $sale->save();

        $store = $sale->store;
        if ($store) {
            $store->stock_at = $sale->stock_at;
            $store->remain_stat = $sale->remain_stat;
            $store->created_at = $sale->created_at;

            $store->save();
        }


//        $filtered = $this->localSales->filter(function ($localSale, $key) use ($sale) {
//            return $localSale->code == $sale->code;
//        });
//
//        // 일치하는게 없다면 INSERT
//        if ($filtered->isEmpty()) {
//            $sale->mask_sync_log_id = self::$maskSyncLog->id;
//            $sale->save();
//        } else {
//
//            foreach ($filtered as $key => $localSale) {
//                if ($localSale->created_at < $sale->created_at) {
//                    $sale->mask_sync_log_id = self::$maskSyncLog->id;
//                    $sale->save();
//                }
//            }
//
//        }

    }
}
