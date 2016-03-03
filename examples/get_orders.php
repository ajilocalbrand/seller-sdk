#!/usr/bin/env php
<?php

// NOTE: we recommend using Composer.
// if you code without using Composer, you can use "autoload.php" library.
require_once(dirname(__FILE__) . '/../autoload.php');

$MM = new Mataharimall\Mataharimall('<your-api-token>', 'sandbox');
$parameter = [
  "start_date" => "2015-10-01",
  "end_date" => "2016-02-28",
  "page" => "1",
  "limit" => "20",
  "sortby" => "id",
  "order" => "desc"
];

try {
    $MM->setDecodeAsArray(true);
    $MM->post('order/list', $parameter);
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
    $page = $response['total'];
    echo sprintf("total row(s) of %s\nPage %s from %s.",
        $page['rows'], $page['page'], $page['totalpage']
    );
}else{
    print_r($response);
    /**
     * output for unauthorized:
     * stdClass Object
        (
            [code] => 401
            [errorMessage] => Unauthorized
            [requestId] => 55107703-adf5-33d5-854f-f079d076f2b2
        )
     */
}

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
