<?php

namespace App\Http\Controllers;

use App\PublicMask\SaleSync;
use App\PublicMask\StoreSync;
use Illuminate\Http\Request;

class SyncController extends Controller
{
    public function syncStores(StoreSync $storeSync)
    {
        $storeSync->sync();
    }

    public function syncSales(SaleSync $saleSync)
    {
        $saleSync->sync();
    }
}
