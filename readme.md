# Nova FCM Campaigns

Send and create Firebase Cloud Notification campaigns to broadcast to mobile devices.

Built on top of the [Laravel FCM Notification Channel](https://github.com/laravel-notification-channels/fcm) library.


## Table of Contents
- [Installation](#installation)
- [Usage](#usage)
- [Configuration](#configuration)


## Installation

Install via composer.
```bash
composer require coreproc/nova-fcm-campaigns
```

Publish migration and configuration files.
```bash
php artisan vendor:publish --provider Coreproc\\NovaFcmCampaigns\\NovaFcmCampaignsServiceProvider
```

Run migrations.
```bash
php artisan migrate
```

Set FCM keys.
```dotenv
FCM_
```

## Usage

### Registering the resource
In order to make the resource appear on the sidebar, register the `FcmCampaign` class in the `App\Providers\NovaServiceProvider` class' `boot()` method.
```php
class NovaServiceProvider extends NovaApplicationServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        Nova::serving(function () {
            Nova::resources([FcmCampaign::class]);
        });
    }
}
```

### Collecting device details
In order to send notifications, device information must be collected. An `StoreDevice` (`store.device`) middleware is provided to
automatically do this. Register the middleware to the routes and configure your apps to send the device details.
```php
namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'api' => [
            'throttle:api',
            'store.device',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
    ];
}
```
The apps must be configured to send the device details through request headers.
```http
X-Device-UDID: Device UDID. Required.
X-Device-FCM-Token: Required.
X-Device-OS: Android/iOS/etc. Optional.
X-Device-Manufacturer: Optional.
X-Device-Model: Optional.
X-Device-App-Version: Optional.
```


### Creating FCM Campaigns
In the "FCM Campaigns" resource, click the "Create FCM Campaign" button and fill in the campaign details.

### Sending Campaigns
On the FCM Campaign's detail page, a "Send Campaign" action will become available. Select and run this action to send
notifications.


## Configuration and Customization
