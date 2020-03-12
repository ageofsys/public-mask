<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MaskSyncLog extends Model
{
    protected $fillable = [
        "target", "request_params", "remote_total_count", "succeed", "sync_started_at"
    ];

    public function errors()
    {
        return $this->hasMany('App\MaskSyncLog');
    }

    public function store()
    {
        return $this->hasMany("App\Store");
    }

    public function sale()
    {
        return $this->hasMany("App\Sale");
    }
}
