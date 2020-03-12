<?php


namespace App\PublicMask\Api;


use App\Sale;

class SaleParser extends Parser
{
    protected $modelClass = Sale::class;

    protected $attributeMap = [
        "code" => "code",
        "stock_at" => "stock_at",
        "remain_stat" => "remain_stat",
        "created_at" => "created_at",
    ];
}
