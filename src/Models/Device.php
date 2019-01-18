<?php

namespace Coreproc\NovaFcmCampaigns\Models;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    protected $guarded = [];

    public function deviceable()
    {
        return $this->morphTo();
    }
}
