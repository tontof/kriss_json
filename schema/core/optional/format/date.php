<?php

include_once(__DIR__ . '/../../inc/formatDateTime.php');

function schema_valid_format_date($data) {
    return schema_valid_format_date_time_format($data, [
        'Y-m-d',
    ]);
}
