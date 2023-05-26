<?php

include_once(__DIR__ . '/../../inc/formatDateTime.php');

function schema_valid_format_date_time($data) {
    return schema_valid_format_date_time_format($data, [
        'Y-m-d\TH:i:s.u\Z',
        'Y-m-d\TH:i:s\Z',
        'Y-m-d\T23:59:60\Z',
        'Y-m-d\TH:i:s.uP',
        'Y-m-d\T23:59:60.uP',
    ]);
}
