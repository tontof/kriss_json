<?php

include_once(__DIR__ . '/uri.php');

function schema_valid_format_uri_reference($data) {
    include(__DIR__ . '/../../inc/rfc.php');
    $regex = '%'.$relativeRef.'%';
    $result = schema_valid_format_uri($data);
    if (!$result) {
        preg_match($regex, $data, $match);
        $result = $match[0] === $data;
    }
    return $result;
}
