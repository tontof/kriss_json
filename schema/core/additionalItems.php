<?php

function schema_valid_additional_items($schema, $data, $original) {
    if (!isset($schema->items)) return true;
    if (is_object($schema->items)) return true;
    $items = isset($schema->items)?array_keys((array)$schema->items):[];
    $additionalItems = $schema->additionalItems;
    return array_reduce(
        array_keys((array)$data),
        function($result, $value) use ($items, $additionalItems, $schema, $data, $original) {
            return $result
                && ($value >= count($items)
                    ?schema_valid($additionalItems, $data[$value], $original)
                    :true);
        },
        true
    );    
}
