<?php

function schema_valid_required($schema, $data, $original) {
    $required = $schema->required;
    if (!is_object($data)) return true;
    return array_reduce(
        $required,
        function($carry, $item) use ($data) {
            return $carry
                && in_array($item, array_keys((array)$data));
        },
        true
    );    
}
