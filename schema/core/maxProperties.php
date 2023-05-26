<?php

function schema_valid_max_properties($schema, $data, $original) {
    $maxProperties = $schema->maxProperties;
    if (!is_object($data)) return true;
    return count((array)$data) <= $maxProperties;
}
