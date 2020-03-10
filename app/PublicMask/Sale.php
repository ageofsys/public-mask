<?php


namespace App\PublicMask;


use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    public $code;
    public $stockAt;
    public $remainStat;
    public $createdAt;
    public $REMAIN_STAT = [
        "plenty" => "100개 이상",
        "some" => "30개 이상 100개미만",
        "few" => "2개 이상 30개 미만",
        "empty" => "1개 이하",
    ];

    public function __construct($json)
    {
        $this->code = $json["code"];
        $this->stockAt = isset($json["stock_at"]) ? $json["stock_at"] : "";
        $this->remainStat = isset($json["remain_stat"]) ? $json["remain_stat"] : "";
        $this->createdAt = isset($json["created_at"]) ? $json["created_at"] : "";
    }

    public function getRemainStatWordAttribute()
    {
        return array_key_exists($this->remainStat, $this->REMAIN_STAT) ?
            $this->REMAIN_STAT[$this->remainStat] : $this->REMAIN_STAT["empty"];
    }

}
