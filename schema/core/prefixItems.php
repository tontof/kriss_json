<?php

function schema_valid_prefix_items($schema, $data, $original) {
    $prefixItems = $schema->prefixItems;
    if (!is_array($data)) return true;
    foreach($prefixItems as $idx => $value) {
        if ($idx >= count($data)) return true;
        if (!schema_valid($value, $data[$idx], $original)) return false;
    }
    return true;
}
