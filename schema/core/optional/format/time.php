<?php

include_once(__DIR__ . '/../../inc/formatDateTime.php');

function schema_valid_format_time($data) {
    return schema_valid_format_date_time_format($data, [
        'H:i:sP\Z',
        '23:59:60P',
        'H:i:s\Z',
        '23:59:60\Z',
        'H:i:s.u\Z',
        'H:i:sP'
    ]);
}

function schema_valid_format_time_with_simple_time($data) {
    return schema_valid_format_time($data) || schema_valid_format_date_time_format($data, ['H:i:s']);
}
