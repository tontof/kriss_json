<?php

function schema_valid_format_uri($data) {
    include(__DIR__ . '/../../inc/rfc.php');
    $regex = '%^'.$URI.'$%u';
    return preg_match($regex, $data);
}
