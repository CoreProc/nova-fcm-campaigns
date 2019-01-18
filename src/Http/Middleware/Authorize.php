<?php

namespace Coreproc\NovaFcmCampaigns\Http\Middleware;

use Coreproc\NovaFcmCampaigns\NovaFcmCampaigns;

class Authorize
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Illuminate\Http\Response
     */
    public function handle($request, $next)
    {
        return resolve(NovaFcmCampaigns::class)->authorize($request) ? $next($request) : abort(403);
    }
}
