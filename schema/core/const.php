<?php

include_once(__DIR__ . '/inc/identical.php');

function schema_valid_const($schema, $data, $original) {
    $const = $schema->const;
    if (is_numeric($const)) return is_numeric($data) && $const == $data;
    return valuesAreIdentical($data, $const);
}