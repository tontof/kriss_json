<?php

function schema_valid_min_properties($schema, $data, $original) {
    $minProperties = $schema->minProperties;
    if (!is_object($data)) return true;
    return $minProperties <= count((array)$data);
}
