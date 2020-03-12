<?php


namespace App\PublicMask\Api;


use App\Store;

class StoreParser extends Parser
{
    protected $modelClass = Store::class;

    protected $attributeMap = [
        "code" => "code",
        "name" => "name",
        "addr" => "addr",
        "type" => "type",
        "lat" => "lat",
        "lng" => "lng"
    ];
}
