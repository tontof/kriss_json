<?php

function schema_valid_all_of($schema, $data, $original) {
    $allOf = $schema->allOf;
    return array_reduce(
        $allOf,
        function($carry, $item) use ($data, $original) {
            return $carry
                && schema_valid($item, $data, $original);
        },
        true
    );    
}
