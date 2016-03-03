#!/usr/bin/env php
<?php

// NOTE: we recommend using Composer.
// if you code without using Composer, you can use "autoload.php" library.
require_once(dirname(__FILE__) . '/../autoload.php');

$MM = new Mataharimall\Mataharimall('<your-api-token>', 'sandbox');
$parameter = [
    'page' => '1',
    'limit' => '5',
    'order' => 'asc',
];

try {
    $MM->post('master/categories', $parameter);
} catch (Mataharimall\MMException $e) {
    echo 'ERROR :' . $e->getMessage();
}

$response = $MM->getResponseBody();
if ($MM->getResponseCode() == 200 && !empty($response)) {
    $results = $response->results;
    foreach ($results as $result) {
        echo "\n". "===============================" ."\n";
        echo 'ID' . ": " . $result->id ."\n";
        echo 'Category' . ": " . $result->category ."\n";
        echo "===============================" ."\n";
    }
    $page = $response->total;
    echo sprintf("total row(s) of %s\nPage %s from %s.",
        $page->rows, $page->page, $page->totalpage
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
