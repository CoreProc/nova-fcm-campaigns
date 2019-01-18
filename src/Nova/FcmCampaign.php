<?php

namespace Coreproc\NovaFcmCampaigns\Nova;

use Coreproc\NovaFcmCampaigns\Nova\Actions\SendCampaign;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Status;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Panel;
use Laravel\Nova\Resource;

class FcmCampaign extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \Coreproc\NovaFcmCampaigns\Models\FcmCampaign::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
    ];

    public function authorizedToUpdate(Request $request)
    {
        if ($this->model()->status == \Coreproc\NovaFcmCampaigns\Models\FcmCampaign::STATUS_SENDING ||
            $this->model()->status == \Coreproc\NovaFcmCampaigns\Models\FcmCampaign::STATUS_SENT) {
            return false;
        }

        return true;
    }

    public function authorizedToForceDelete(Request $request)
    {
        return false;
    }

    public function authorizedToDelete(Request $request)
    {
        if ($this->model()->status == \Coreproc\NovaFcmCampaigns\Models\FcmCampaign::STATUS_SENDING ||
            $this->model()->status == \Coreproc\NovaFcmCampaigns\Models\FcmCampaign::STATUS_SENT) {
            return false;
        }

        return true;
    }

    public function authorizedToAttachAny(NovaRequest $request, $model)
    {
        if ($this->model()->status == \Coreproc\NovaFcmCampaigns\Models\FcmCampaign::STATUS_SENDING ||
            $this->model()->status == \Coreproc\NovaFcmCampaigns\Models\FcmCampaign::STATUS_SENT) {
            return false;
        }

        return true;
    }

    public static function label()
    {
        return 'FCM Campaigns';
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make()->sortable(),

            Text::make('Name')
                ->rules('required')
                ->help('Name this campaign so it is easily identifiable.'),

            Status::make('Status')
                ->loadingWhen([\Coreproc\NovaFcmCampaigns\Models\FcmCampaign::STATUS_SENDING])
                ->failedWhen([\Coreproc\NovaFcmCampaigns\Models\FcmCampaign::STATUS_FAILED]),

            DateTime::make('Created At')->exceptOnForms(),

            DateTime::make('Updated At')->exceptOnForms(),

            new Panel('Notification Details', $this->notificationDetails()),

            BelongsToMany::make('Devices', 'devices', Device::class),
        ];
    }

    public function notificationDetails()
    {
        return [
            Text::make('Title')
                ->rules('required')
                ->hideFromIndex()
                ->help('Title of the notification when displayed on the app.'),

            Textarea::make('Body')
                ->rows(3)
                ->rules('required')
                ->withMeta([
                    'extraAttributes' => [
                        'placeholder' => 'The notification message',
                    ],
                ])
                ->help('App viewable character limit 180.')
                ->alwaysShow(),
        ];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [
            new SendCampaign,
        ];
    }
}
