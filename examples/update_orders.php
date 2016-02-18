#!/usr/bin/env php
<?php

// NOTE: we recommend using Composer.
// if you code without using Composer, you can use "autoload.php" library.
require_once(dirname(__FILE__) . '/../autoload.php');

$MM = new Mataharimall\Mataharimall('<your-api-token>');

//example parameters.
$parameter = [
    [
        "so_store_number" => "<string | required >",
        "status" => "< string | optional | (canceled|shipped) >",
        "reason" => "< string | required if status is 'canceled' >",
        "shipping_provider" => "< string | required if status is 'shipped' >",
        "tracking_number" => "< string | required if status is 'shipped' >"
    ],
    [
        "so_store_number" => "<string | required >",
        "status" => "< string | optional | (canceled|shipped) >",
        "reason" => "< string | required if status is 'canceled' >",
        "shipping_provider" => "< string | required if status is 'shipped' >",
        "tracking_number" => "< string | required if status is 'shipped' >"
    ],
];

try {
    // set response as an Array (default: Object).
    $MM->setDecodeAsArray(true);
    $MM->post('order/update', $parameter);
} catch (Mataharimall\MMException $e) {
    echo 'ERROR :' . $e->getMessage();
}

$response = $MM->getResponseBody();
if ($MM->getResponseCode() == 200 && !empty($response)) {
    $results = $response['results'];
    foreach ((array)$results as $result) {
        echo "\n". "===============================" ."\n";
        getChildrens($result);
        echo "===============================" ."\n";
    }
} else {
    echo $response['errorMessage'];
}

// loop through all children(s).
function getChildrens($arr)
{
    if (!is_array($arr)) {
        return false;
    }

    foreach ($arr as $key => $value) {
        if (!is_array($value)) {
            echo $key . ' : ' . $value ."\n";
        } else {
            echo $key .": \n";
            getChildrens($value);
        }
    }
}
