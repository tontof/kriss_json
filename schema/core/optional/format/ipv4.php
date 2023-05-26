<?php

function schema_valid_format_ipv4($data) {
    include(__DIR__ . '/../../inc/rfc.php');
    $regex = '%^'.$IPv4address.'$%';
    return preg_match($regex, $data);
}
