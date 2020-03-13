<?php


namespace App\PublicMask;


use App\MaskSyncErrorLog;
use App\MaskSyncLog;
use App\PublicMask\Api\Result\StoreResult;
use App\Repositories\PublicMaskApiRepository;

class StoreSync
{
    private $repository;

    public static $maskSyncLog;

    public function __construct(PublicMaskApiRepository $publicMaskApiRepository)
    {
        $this->repository = $publicMaskApiRepository;
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
                    "target" => "store",
                    "request_params" => collect($requestParameter)->toJson(),
                    "sync_started_at" => now()
                ]);

                $rawStoreResult = $this->repository->getRemoteStores($requestParameter);

                $maskSync->remote_total_count = $rawStoreResult["totalCount"];

                $storeResult = new StoreResult($rawStoreResult);

                $this->saveMany($storeResult->stores);

                if ($totalPages == null) {
                    $totalPages = $storeResult->totalPages;
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

        }



    }

    public function saveMany($stores)
    {
        foreach ($stores as $store) {
            $this->saveOne($store);
        }
    }

    public function saveOne($store)
    {
        self::$maskSyncLog->store()->save($store);
    }

}
