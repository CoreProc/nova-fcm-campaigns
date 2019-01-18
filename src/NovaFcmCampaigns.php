<?php

namespace Coreproc\NovaFcmCampaigns;

use Laravel\Nova\Nova;
use Laravel\Nova\Tool;

class NovaFcmCampaigns extends Tool
{
    /**
     * Perform any tasks that need to happen when the tool is booted.
     *
     * @return void
     */
    public function boot()
    {
        Nova::script('nova-fcm-campaigns', __DIR__.'/../dist/js/tool.js');
        Nova::style('nova-fcm-campaigns', __DIR__.'/../dist/css/tool.css');
    }

    /**
     * Build the view that renders the navigation links for the tool.
     *
     * @return \Illuminate\View\View
     */
    public function renderNavigation()
    {
        return view('nova-fcm-campaigns::navigation');
    }
}
