

# Methods

## Create Notification

```php
$instance = GBSignal::createNotification(); # Create Notification

$instance->notification # Adjust the notification
  ->setHead('Selamlar') # Set Head
  ->setContent('Selam') # Set Content
  ->setData('key', 'value') # Set Data
  ->setSendAfter(Carbon::now()->addMinutes(10)) # Set Send After (Must Be Carbon Instance)
  ->addButton('id', 'button') # Add Button
  ->addButton('id2', 'button2'); # Add Button

```

## Send Notification
```php
$response = $instance->sendToAll(); # Send To All Users
$response = $instance->sendToExternal(['external_id1', 'external_id2']); # Send To External Users
$response = $instance->sendToTag('company_id', '=', [1,2,3,4,5]); # Send To Users by tag
```

## Delete
```php
$oldNotification =  \HumblDump\GBSignal\OneSignal\Notification::query()->first();
$response = GBSignal::deleteNotification($oldNotification); # Delete Notification (Takes model or OneSignal notification id as string)
```

## Get
```php
$response = GBSignal::getNotificationList(); # Get notification list

use HumblDump\GBSignal\OneSignal\Notification;
$oldNotification =  \HumblDump\GBSignal\OneSignal\Notification::query()->first();
$response = GBSignal::getNotification($oldNotification); # Get notification invidual
```

## Get Device List
```php
$response = GBSignal::getDeviceList(); // Get device list
```



## Adding GBSignal to the repository

1. Add the repository to your `composer.json` file:

```json
"repositories": [
    {
        "type": "vcs",
        "url": "git@github.com:gaziantep-bilisim/onesignal_laravel.git"
    }
],
```

2. Add Repository to The Require Block on `composer.json`

```json
"require": [
  {
    "gaziantep-bilisim/onesignal_laravel": "dev-master"
  }
],
```

3. Add This to the `composer.json`
```
"extra": {
  "laravel": {
    "dont-discover": [
      "gaziantep-bilisim/onesignal_laravel"
    ]
  }
}
```

4. Run
```bash
composer update
```

5. Add GBSignalServiceProvider  to the `App/Config/App.php`
```php
  'providers' => [
    HumblDump\GBSignal\GBSignalServiceProvider::class,
  ]
```

6. Publish The Vendor and Migrate
```bash
php artisan vendor:publish --provider="HumblDump\GBSignal\GBSignalServiceProvider"
php artisan migrate
```

7. Setup the GBSignal.php on Config folder
