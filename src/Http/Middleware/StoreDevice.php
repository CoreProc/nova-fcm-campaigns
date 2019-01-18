<?php

namespace Coreproc\NovaFcmCampaigns\Http\Middleware;

use Closure;
use Coreproc\NovaFcmCampaigns\Models\Device;
use Illuminate\Validation\UnauthorizedException;

class StoreDevice
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param bool $isRequired
     * @return mixed
     */
    public function handle($request, Closure $next, $isRequired = true)
    {
        $deviceUdid = $request->header('X-Device-UDID');

        if (empty($deviceUdid) && ! $isRequired) {
            // We continue on
            return $next($request);
        }

        if (empty($deviceUdid) && $isRequired) {
            throw new UnauthorizedException('You need to specify your device details.');
        }

        // We save the device details
        $device = Device::query()->updateOrCreate([
            'udid' => $deviceUdid,
        ], [
            'os' => $request->header('X-Device-OS'),
            'os_version' => $request->header('X-Device-OS-Version'),
            'manufacturer' => $request->header('X-Device-Manufacturer'),
            'model' => $request->header('X-Device-Model'),
            'fcm_token' => $request->header('X-Device-FCM-Token'),
            'app_version' => $request->header('X-Device-App-Version'),
        ]);

        $request->device = $device;

        return $next($request);
    }

    public function terminate($request, $response)
    {
        $user = $request->user();

        if (! empty($user) && ! empty($request->device)) {
            $request->device->setDeviceable($user);
            $request->device->save();
        }
    }
}
