# Mataharimall Seller SDK #

PHP wrapper for Mataharimall Seller Center API.

## Installation ##

### Composer Installation ###

```sh
$ composer require mataharimall/php-sdk
```

### Manual Installation ###
download latest release & require 'autoload.php'.

```sh
require "mataharimall-php-sdk/autoload.php";

use Mataharimall\Mataharimall;
```

## How to ##

Check **[API Seller Apiary](http://docs.apiforseller.apiary.io/)**, for available endpoints.

### Basic Usage ###

```sh
$mataharimall = new Mataharimall(API_TOKEN, ENV);
$mataharimall->post($url , $parameter);

//get headers
$headers = $mataharimall->getResponseHeaders();

//get response Http Code
$httpCode = $mataharimall->getResponseCode();

//get body
$body = $mataharimall->getResponseBody();

```
### Proxy Enabled ###
```sh
$request = new MMRequest();
$request->setProxy([
     'CURLOPT_PROXY' => PROXY_HOST,
     'CURLOPT_PROXYUSERPWD' => PROXY_USERPWD,
     'CURLOPT_PROXYPORT' => PROXY_PORT,
]);
$mataharimall = new Mataharimall(API_TOKEN, ENV, $request);
$results = $mataharimall->post($url , $parameter);
```

### Error Handling ###

```sh
try {
    $mataharimall = new Mataharimall(API_TOKEN, ENV);
    $mataharimall->post($url, $parameter);
} catch (MMException $e) {
    // print exception.
}

$result = $mataharimall->getResponseBody();
if ($mataharimall->getResponseCode() == 200 && !empty($result)) {
    // success
} else {
    // error
}
```

