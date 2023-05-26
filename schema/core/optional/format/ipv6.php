<?php

function schema_valid_format_ipv6($data) {
    include(__DIR__ . '/../../inc/rfc.php');
    $regex = '%^'.$IPv6address.'$%';
    return preg_match($regex, $data);
}
