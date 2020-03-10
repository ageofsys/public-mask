<?php


namespace App\PublicMask;


use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    public $code;
    public $name;
    public $addr;
    public $type;
    public $lat;
    public $lng;
    public $STORE_TYPE = [
        "01" => "약국",
        "02" => "우체국",
        "03" => "농협",
    ];

    public function __construct($json)
    {
        $this->code = $json["code"];
        $this->name = isset($json["name"]) ? $json["name"] : "";
        $this->addr = isset($json["addr"]) ? $json["addr"] : "";
        $this->type = isset($json["type"]) ? $json["type"] : "";
        $this->lat = isset($json["lat"]) ? $json["lat"] : "";
        $this->lng = isset($json["lng"]) ? $json["lng"] : "";
    }

    public function getTypeWordAttribute()
    {
        return $this->STORE_TYPE[$this->type];
    }
}
