<?php

function schema_valid_property_names($schema, $data, $original) {
    $propertyNames = $schema->propertyNames;
    return array_reduce(
        array_keys((array)$data),
        function($result, $item) use ($propertyNames, $original) {
            return $result
                && schema_valid($propertyNames, $item, $original);
        },
        true
    );
}
