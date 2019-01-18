<?php

namespace Coreproc\NovaFcmCampaigns\Observers;

use Coreproc\NovaFcmCampaigns\Models\Device;
use Coreproc\NovaFcmCampaigns\Models\FcmCampaign;
use Illuminate\Support\Facades\Log;

class FcmCampaignObserver
{
    /**
     * Handle the fcm campaign "created" event.
     *
     * @param FcmCampaign $fcmCampaign
     * @return void
     */
    public function created(FcmCampaign $fcmCampaign)
    {
        $devices = Device::query()->whereNotNull('fcm_token')->get();

        foreach ($devices->chunk(1000) as $devices) {
            $fcmCampaign->devices()->attach($devices);
        }
    }
}
