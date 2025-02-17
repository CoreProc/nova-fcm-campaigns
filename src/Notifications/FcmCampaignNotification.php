<?php

namespace Coreproc\NovaFcmCampaigns\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use NotificationChannels\Fcm\FcmChannel;
use NotificationChannels\Fcm\FcmMessage;
use NotificationChannels\Fcm\FcmNotification;
use NotificationChannels\Fcm\Resources\AndroidConfig;
use NotificationChannels\Fcm\Resources\AndroidNotification;
use NotificationChannels\Fcm\Resources\ApnsConfig;

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
        $fcmNotification = \NotificationChannels\Fcm\Resources\Notification::create()
            ->setTitle($notifiable->title)
            ->setBody($notifiable->body);

        $androidConfig = AndroidConfig::create()
            ->setPriority($notifiable->priority)
            ->setCollapseKey($notifiable->collapse_key)
            ->setNotification(AndroidNotification::create()
                ->setColor($notifiable->color)
                ->setSound($notifiable->sound)
                ->setChannelId($notifiable->android_channel_id)
                ->setIcon($notifiable->icon)
                ->setTag($notifiable->tag)
                ->setClickAction($notifiable->click_action)
                ->setBodyLocKey($notifiable->body_loc_key)
                ->setBodyLocArgs($notifiable->body_loc_args)
                ->setTitleLocKey($notifiable->title_loc_key)
                ->setTitleLocArgs($notifiable->title_loc_args)
            );

        $apnsConfig = ApnsConfig::create()
            ->setHeaders([
                'apns-priority' => $notifiable->priority,
                'apns-collapse-id' => $notifiable->collapse_key,
            ])
            ->setPayload([
                'aps' => [
                    'sound' => $notifiable->sound,
                    'badge' => $notifiable->badge,
                ],
            ]);

        return FcmMessage::create()
            ->setData($notifiable->data)
            ->setNotification($fcmNotification)
            ->setCondition($notifiable->condition)
            ->setAndroid($androidConfig)
            ->setApns($apnsConfig);
    }
}
