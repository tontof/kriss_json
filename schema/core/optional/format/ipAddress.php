<?php

include_once(__DIR__ . '/ipv4.php');

function schema_valid_format_ip_address($data) {
    return schema_valid_format_ipv4($data);
}
