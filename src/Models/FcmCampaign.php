<?php

namespace Coreproc\NovaFcmCampaigns\Models;

use Coreproc\NovaFcmCampaigns\Notifications\FcmCampaignNotification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Nova\Actions\Actionable;

class FcmCampaign extends Model
{
    use SoftDeletes, Notifiable, Actionable;

    const STATUS_PENDING = 'Pending';
    const STATUS_SENDING = 'Sending';
    const STATUS_SENT = 'Sent';
    const STATUS_CANCELLED = 'Cancelled';
    const STATUS_FAILED = 'Failed';

    const RECIPIENTS_ALL = 1;
    const RECIPIENTS_DEVICES_WITH_USERS = 2;

    protected $fillable = [
        'name',
        'description',
        'condition',
        'collapse_key',
        'priority',
        'content_available',
        'mutable_content',
        'time_to_live',
        'restricted_package_name',
        'dry_run',
        'data',
        'title',
        'body',
        'android_channel_id',
        'icon',
        'badge',
        'sound',
        'tag',
        'color',
        'click_action',
        'body_loc_key',
        'body_loc_args',
        'title_loc_key',
        'title_loc_args',
        'status',
        'sent_at',
        'cancelled_at',
    ];

    protected $casts = [
        'time_to_live' => 'integer',
    ];

    protected $dates = [
        'sent_at',
        'cancelled_at',
    ];

    public function devices()
    {
        return $this->belongsToMany(Device::class, 'fcm_campaign_device');
    }

    public function send()
    {
        $this->update([
            'status' => self::STATUS_SENDING,
        ]);

        $this->notify(app(config('nova_fcm_campaigns.fcm_campaign_notification', FcmCampaignNotification::class)));

        $this->update([
            'status' => self::STATUS_SENT,
            'sent_at' => now(),
        ]);
    }

    public function routeNotificationForFcm()
    {
        return $this->devices()->pluck('fcm_token')->toArray();
    }
}
