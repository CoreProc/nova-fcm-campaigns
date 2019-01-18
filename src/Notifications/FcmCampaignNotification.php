<?php

namespace Coreproc\NovaFcmCampaigns\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use NotificationChannels\Fcm\FcmChannel;
use NotificationChannels\Fcm\FcmMessage;
use NotificationChannels\Fcm\FcmNotification;

class FcmCampaignNotification extends Notification
{
    use Queueable;

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [FcmChannel::class];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed $notifiable
     * @return FcmMessage
     */
    public function toFcm($notifiable)
    {
        $fcmNotification = FcmNotification::create()
            ->setTitle($notifiable->title)
            ->setBody($notifiable->body)
            ->setSound($notifiable->sound)
            ->setAndroidChannelId($notifiable->android_channel_id)
            ->setIcon($notifiable->icon)
            ->setBadge($notifiable->badge)
            ->setTag($notifiable->tag)
            ->setColor($notifiable->color)
            ->setClickAction($notifiable->click_action)
            ->setBodyLocKey($notifiable->body_loc_key)
            ->setBodyLocArgs($notifiable->body_loc_args)
            ->setTitleLocKey($notifiable->title_loc_key)
            ->setTitleLocArgs($notifiable->title_loc_args);

        return FcmMessage::create()
            ->setCondition($notifiable->condition)
            ->setCollapseKey($notifiable->collapse_key)
            ->setPriority($notifiable->priority)
            ->setContentAvailable($notifiable->content_available)
            ->setMutableContent($notifiable->mutable_content)
            ->setTimeToLive($notifiable->time_to_live)
            ->setData($notifiable->data)
            ->setNotification($fcmNotification);
    }
}
