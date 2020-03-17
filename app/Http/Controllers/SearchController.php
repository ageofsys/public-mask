<?php

namespace App\Http\Controllers;

use App\PublicMask\LatLng;
use App\Store;
use App\MaskSyncLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class SearchController extends Controller
{
    public function index()
    {
        $routeName = Route::currentRouteName();

        $latestMaskSyncLog = MaskSyncLog::where("succeed", "=", 1)->orderBy("created_at", "desc")->first();

	    return view("search.index")->with("latestMaskSyncLog", $latestMaskSyncLog)->with("routeName", $routeName);
    }

    public function searchOnMap(Request $request)
    {
        $swLat = $request->sw_lat;
        $swLng = $request->sw_lng;
        $neLat = $request->ne_lat;
        $neLng = $request->ne_lng;

        $swLatLng = new LatLng($swLat, $swLng);
        $enLatLng = new LatLng($neLat, $neLng);

        $stores = Store::query()->whereBetween("lat", [$swLatLng->getLat(), $enLatLng->getLat()])
            ->whereBetween("lng", [$swLatLng->getLng(), $enLatLng->getLng()])->get();

//        foreach ($stores as $store) {
//            $latestSale = isset($store->sales[0]) ? $store->sales[0] : null;
//
//            if ( ! $latestSale) continue;
//
//            $store->stock_at = $latestSale->stock_at;
//            $store->remain_stat = $latestSale->remain_stat;
//            $store->created_at = $latestSale->created_at;
//        }
        $latestMaskSyncLog = MaskSyncLog::where("succeed", "=", 1)->orderBy("created_at", "desc")->first();

        return response()->json(["stores" => $stores, "latestMaskSyncLog" => $latestMaskSyncLog]);


    }
}
