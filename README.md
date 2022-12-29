

# Bildirim Metodları

## Bildirim Oluşturma

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

## Bildirimi Gönderme
```php
/*
Onesignal üzerinde kayıtlı herkes'e gönderir
*/
$response = $instance->sendToAll();

/*
Onesignal üzerinde external id'leri kullanarak bildirim gönderme
Array Beklemektedir
Array ürünleri String olmalıdır
*/
$response = $instance->sendToExternal(['external_id1', 'external_id2']);

/*
Onesignal üzerinde kaydedilen tagler'i kullanarak bildirim gönderme
$key tagin ismi
$array bu taga için değerler !array beklemektedir
*/
$response = $instance->sendToTag($key, '=', $array); //Onesignal e kaydedilen tagları kullanarak bildirim gönderme
```

## Bildirim Modeli
> 	Oluşturulan ve gönderilen bildirimler veritabanında kaydedilir
> 	Bu oluşturulan modele `HumblDump\GBSignal\OneSignal\Notification` sınıfı üzerinden erişebilirsiniz

## Bildirim Bilgilerini Çekme
```php
use HumblDump\GBSignal\OneSignal\Notification; //modelin sınıfını çek

/*
Veri tabanı üzerinden gönderdiğimiz modeli çek
*/
$oldNotification =  \HumblDump\GBSignal\OneSignal\Notification::query()->first();

/*
Metoda çektiğimiz bu modeli aktar
*/
$response = GBSignal::getNotification($oldNotification); # Get notification invidual

```
> $response success ve error dan oluşan bir STDClass
> $response->success = bir [TIKLA](https://paste.ofcode.org/4PnAg5hzNERVvE86kUbQqS "obj") collection


## Bildirim Silme
```php
$oldNotification =  \HumblDump\GBSignal\OneSignal\Notification::query()->first();
$response = GBSignal::deleteNotification($oldNotification); // Veritabanından çekilen notification urununu beklemektedir
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


# Bildirim Metodları

## Bildirim Oluşturma

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

## Bildirimi Gönderme
```php
/*
Onesignal üzerinde kayıtlı herkes'e gönderir
*/
$response = $instance->sendToAll();

/*
Onesignal üzerinde external id'leri kullanarak bildirim gönderme
Array Beklemektedir
Array ürünleri String olmalıdır
*/
$response = $instance->sendToExternal(['external_id1', 'external_id2']);

/*
Onesignal üzerinde kaydedilen tagler'i kullanarak bildirim gönderme
$key tagin ismi
$array bu taga için değerler !array beklemektedir
*/
$response = $instance->sendToTag($key, '=', $array); //Onesignal e kaydedilen tagları kullanarak bildirim gönderme
```

## Bildirim Modeli
> 	Oluşturulan ve gönderilen bildirimler veritabanında kaydedilir
> 	Bu oluşturulan modele `HumblDump\GBSignal\OneSignal\Notification` sınıfı üzerinden erişebilirsiniz

## Bildirim Bilgilerini Çekme
```php
use HumblDump\GBSignal\OneSignal\Notification; //modelin sınıfını çek

/*
Veri tabanı üzerinden gönderdiğimiz modeli çek
*/
$oldNotification =  \HumblDump\GBSignal\OneSignal\Notification::query()->first();

/*
Metoda çektiğimiz bu modeli aktar
*/
$response = GBSignal::getNotification($oldNotification); # Get notification invidual

```
> $response success ve error dan oluşan bir STDClass
> $response->success = bir [TIKLA](https://paste.ofcode.org/4PnAg5hzNERVvE86kUbQqS "obj") collection


## Bildirim Silme
```php
$oldNotification =  \HumblDump\GBSignal\OneSignal\Notification::query()->first();
$response = GBSignal::deleteNotification($oldNotification); // Veritabanından çekilen notification urununu beklemektedir
```

## Get Device List
```php
$response = GBSignal::getDeviceList(); // Get device list
```



## Adding GBSignal to the repository

1. Install Package Using `composer`:
```bash
    composer require gaziantep-bilisim/onesignal_laravel
```

2. Add GBSignalServiceProvider  to the `Config/App.php`
```php
  'providers' => [
    HumblDump\GBSignal\GBSignalServiceProvider::class,
  ]
```

3. Add GBSignal Allias to the `Config/App.php` aliases
```php
    'aliases' => Facade::defaultAliases()->merge([
        // 'ExampleClass' => App\Example\ExampleClass::class,
        'GBSignal' => HumblDump\GBSignal\GBSignalFacade::class,
    ])->toArray(),
```

6. Publish The Vendor and Migrate
```bash
    php artisan vendor:publish --provider="HumblDump\GBSignal\GBSignalServiceProvider"
    php artisan migrate
```

7. Add env Variables and adjuct `Config\GBSignal.php`
```env
ONESIGNAL_APP_ID= ""
ONESIGNAL_AUTH_KEY= ""
ONESIGNAL_AUTHORIZE= "Basic"
ONESIGNAL_TIMEOUT= "10"
ONESIGNAL_POOL_SIZE= "10"
```


# Bildirim Metodları

## Bildirim Oluşturma

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

## Bildirimi Gönderme
```php
/*
Onesignal üzerinde kayıtlı herkes'e gönderir
*/
$response = $instance->sendToAll();

/*
Onesignal üzerinde external id'leri kullanarak bildirim gönderme
Array Beklemektedir
Array ürünleri String olmalıdır
*/
$response = $instance->sendToExternal(['external_id1', 'external_id2']);

/*
Onesignal üzerinde kaydedilen tagler'i kullanarak bildirim gönderme
$key tagin ismi
$array bu taga için değerler !array beklemektedir
*/
$response = $instance->sendToTag($key, '=', $array); //Onesignal e kaydedilen tagları kullanarak bildirim gönderme
```

## Bildirim Modeli
> 	Oluşturulan ve gönderilen bildirimler veritabanında kaydedilir
> 	Bu oluşturulan modele `HumblDump\GBSignal\OneSignal\Notification` sınıfı üzerinden erişebilirsiniz

## Bildirim Bilgilerini Çekme
```php
use HumblDump\GBSignal\OneSignal\Notification; //modelin sınıfını çek

/*
Veri tabanı üzerinden gönderdiğimiz modeli çek
*/
$oldNotification =  \HumblDump\GBSignal\OneSignal\Notification::query()->first();

/*
Metoda çektiğimiz bu modeli aktar
*/
$response = GBSignal::getNotification($oldNotification); # Get notification invidual

```
> $response success ve error dan oluşan bir STDClass
> $response->success = bir [TIKLA](https://paste.ofcode.org/4PnAg5hzNERVvE86kUbQqS "obj") collection


## Bildirim Silme
```php
$oldNotification =  \HumblDump\GBSignal\OneSignal\Notification::query()->first();
$response = GBSignal::deleteNotification($oldNotification); // Veritabanından çekilen notification urununu beklemektedir
```

## Get Device List
```php
$response = GBSignal::getDeviceList(); // Get device list
```



## Adding GBSignal to the repository

1. Install Package Using `composer`:
```bash
    composer require gaziantep-bilisim/onesignal_laravel
```

2. Add GBSignalServiceProvider  to the `Config/App.php`
```php
  'providers' => [
    HumblDump\GBSignal\GBSignalServiceProvider::class,
  ]
```

3. Add GBSignal Allias to the `Config/App.php` aliases
```php
    'aliases' => Facade::defaultAliases()->merge([
        // 'ExampleClass' => App\Example\ExampleClass::class,
        'GBSignal' => HumblDump\GBSignal\GBSignalFacade::class,
    ])->toArray(),
```

6. Publish The Vendor and Migrate
```bash
    php artisan vendor:publish --provider="HumblDump\GBSignal\GBSignalServiceProvider"
    php artisan migrate
```

7. Add env Variables and adjuct `Config\GBSignal.php`
```env
ONESIGNAL_APP_ID= ""
ONESIGNAL_AUTH_KEY= ""
ONESIGNAL_AUTHORIZE= "Basic"
ONESIGNAL_TIMEOUT= "10"
ONESIGNAL_POOL_SIZE= "10"
```


# Bildirim Metodları

## Bildirim Oluşturma

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

## Bildirimi Gönderme
```php
/*
Onesignal üzerinde kayıtlı herkes'e gönderir
*/
$response = $instance->sendToAll();

/*
Onesignal üzerinde external id'leri kullanarak bildirim gönderme
Array Beklemektedir
Array ürünleri String olmalıdır
*/
$response = $instance->sendToExternal(['external_id1', 'external_id2']);

/*
Onesignal üzerinde kaydedilen tagler'i kullanarak bildirim gönderme
$key tagin ismi
$array bu taga için değerler !array beklemektedir
*/
$response = $instance->sendToTag($key, '=', $array); //Onesignal e kaydedilen tagları kullanarak bildirim gönderme
```

## Bildirim Modeli
> 	Oluşturulan ve gönderilen bildirimler veritabanında kaydedilir
> 	Bu oluşturulan modele `HumblDump\GBSignal\OneSignal\Notification` sınıfı üzerinden erişebilirsiniz

## Bildirim Bilgilerini Çekme
```php
use HumblDump\GBSignal\OneSignal\Notification; //modelin sınıfını çek

/*
Veri tabanı üzerinden gönderdiğimiz modeli çek
*/
$oldNotification =  \HumblDump\GBSignal\OneSignal\Notification::query()->first();

/*
Metoda çektiğimiz bu modeli aktar
*/
$response = GBSignal::getNotification($oldNotification); # Get notification invidual

```
> $response success ve error dan oluşan bir STDClass
> $response->success = bir [TIKLA](https://paste.ofcode.org/4PnAg5hzNERVvE86kUbQqS "obj") collection


## Bildirim Silme
```php
$oldNotification =  \HumblDump\GBSignal\OneSignal\Notification::query()->first();
$response = GBSignal::deleteNotification($oldNotification); // Veritabanından çekilen notification urununu beklemektedir
```

## Get Device List
```php
$response = GBSignal::getDeviceList(); // Get device list
```



## Adding GBSignal to the repository

1. Install Package Using `composer`:
```bash
    composer require gaziantep-bilisim/onesignal_laravel
```

2. Add GBSignalServiceProvider  to the `Config/App.php`
```php
  'providers' => [
    HumblDump\GBSignal\GBSignalServiceProvider::class,
  ]
```

3. Add GBSignal Allias to the `Config/App.php` aliases
```php
    'aliases' => Facade::defaultAliases()->merge([
        // 'ExampleClass' => App\Example\ExampleClass::class,
        'GBSignal' => HumblDump\GBSignal\GBSignalFacade::class,
    ])->toArray(),
```

6. Publish The Vendor and Migrate
```bash
    php artisan vendor:publish --provider="HumblDump\GBSignal\GBSignalServiceProvider"
    php artisan migrate
```

7. Add env Variables and adjuct `Config\GBSignal.php`
```env
ONESIGNAL_APP_ID= ""
ONESIGNAL_AUTH_KEY= ""
ONESIGNAL_AUTHORIZE= "Basic"
ONESIGNAL_TIMEOUT= "10"
ONESIGNAL_POOL_SIZE= "10"
```
