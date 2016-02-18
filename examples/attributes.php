#!/usr/bin/env php
<?php

// NOTE: we recommend using Composer.
// if you code without using Composer, you can use "autoload.php" library.
require_once(dirname(__FILE__) . '/../autoload.php');

$MM = new Mataharimall\Mataharimall('<your-api-token>');
$parameter = [
    'category_id' => 5,
];

try {
    $MM->post('master/attributes', $parameter);
} catch (Mataharimall\MMException $e) {
    echo 'ERROR :' . $e->getMessage();
}

$response = $MM->getResponseBody();
if ($MM->getResponseCode() == 200 && !empty($response)) {
    $results = $response->results;
    foreach ($results as $result) {
        echo "\n". "===============================" ."\n";
        echo 'Id' . ": " . $result->id ."\n";
        echo 'Attribute' . ": " . $result->attribute ."\n";
        echo 'Type' . ": " . $result->type ."\n";
        echo 'Options' . ": \n";
        if ($result->options !== null) {
            foreach ($result->options as $option) {
                echo $option ."\n";
            }
        } else {
            echo 'NULL' ."\n";
        }
        echo "===============================" ."\n";
    }
}
