<?php

namespace Coreproc\NovaFcmCampaigns\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\MorphTo;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Resource;

class Device extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \Coreproc\NovaFcmCampaigns\Models\Device::class;

    public static $group = 'FCM Campaigns';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    public function title()
    {
        return $this->udid . ' - ' . $this->os;
    }

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
        'udid',
        'os',
    ];

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
            Text::make('UDID'),
            Text::make('OS'),
            MorphTo::make('Deviceable'),
            Text::make('OS Version')->hideFromIndex(),
            Text::make('Manufacturer')->hideFromIndex(),
            Text::make('Model')->hideFromIndex(),
            Text::make('App Version')->hideFromIndex(),
        ];
    }
}
