# Mataharimall PHP SDK #

this is the PHP wrapper for Mataharimall Seller Center API.

## Installation ##

### Composer Installation ###

```sh
$ composer require mataharimall/php-sdk
```

### Manual Installation ###
download latest release & require 'autoload.php'.

```sh
require "mataharimall-php-sdk/autoload.php";

use Mataharimall\API;
```

## How to ##

Check **[API Seller Apiary](http://docs.apiforseller.apiary.io/)**, for available endpoints.

### Basic Usage ###

```sh
$mataharimall = new Mataharimall(API_TOKEN);
$results = $mataharimall->post($url , $parameter);
```
### Proxy Enabled ###
```sh
$request = new MMRequest();
$request->setProxy([
     'CURLOPT_PROXY' => PROXY_HOST,
     'CURLOPT_PROXYUSERPWD' => PROXY_USERPWD,
     'CURLOPT_PROXYPORT' => PROXY_PORT,
]);
$mataharimall = new Mataharimall(API_TOKEN, $request);
$results = $mataharimall->post($url , $parameter);
```

### Error Handling ###

```sh
$results = $mataharimall->post($url, $parameter);
if ($mataharimall->getLastHttpCode() == 200) {
    // success
} else {
    // error
}
```

