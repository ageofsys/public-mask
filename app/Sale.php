<?php


namespace App;


use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    public $REMAIN_STAT = [
        "plenty" => "100개 이상",
        "some" => "30개 이상 100개미만",
        "few" => "2개 이상 30개 미만",
        "empty" => "1개 이하",
    ];

    public $timestamps = false;

    public function store()
    {
        return $this->belongsTo("App\Store", "code", "code");
    }

    public function getRemainStatWordAttribute()
    {
        return array_key_exists($this->remain_stat, $this->REMAIN_STAT) ?
            $this->REMAIN_STAT[$this->remain_stat] : $this->REMAIN_STAT["empty"];
    }

    public function getStockAtWordAttribute()
    {
        return date("m월 d일 H시 i분", strtotime($this->stock_at));
    }

    public function getCreatedAtWordAttribute()
    {
        return date("m월 d일 H시 i분", strtotime($this->created_at));
    }

}
