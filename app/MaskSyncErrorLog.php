<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MaskSyncErrorLog extends Model
{
    protected $fillable = ["mask_sync_log_id", "title", "content"];

    public function maskSyncLog()
    {
        return $this->belongsTo('App\MaskSyncLog');
    }
}
