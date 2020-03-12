<?php


namespace App;


use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    public $STORE_TYPE = [
        "01" => "약국",
        "02" => "우체국",
        "03" => "농협",
    ];

    protected $with = ["sales"];

    public $timestamps = false;

    public function maskSyncLog()
    {
        return $this->belongsTo("App\MaskSyncLog");
    }

    public function sales()
    {
        return $this->hasMany("App\Sale", "code", "code");
    }

    public function latestSale()
    {
        return $this->hasMany("App\Sale", "code", "code")->first();
    }

    public function getTypeWordAttribute()
    {
        return $this->STORE_TYPE[$this->type];
    }
}
