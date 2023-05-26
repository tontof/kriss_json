<?php

function schema_valid_properties($schema, $data, $original) {
    $properties = $schema->properties;
    return array_reduce(
        array_keys((array)$properties),
        function($result, $item) use ($properties, $data, $original) {
            if (isset($properties->$item->required) && is_bool($properties->$item->required) && $properties->$item->required) {
                $result = $result && property_exists($data, $item);
            }
            return $result
                && (isset($data->$item)
                    ?schema_valid($properties->$item, $data->$item, $original)
                    :true);
        },
        true
    );
}
