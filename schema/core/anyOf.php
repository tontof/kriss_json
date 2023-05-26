<?php

function schema_valid_any_of($schema, $data, $original) {
    $anyOf = $schema->anyOf;
    return array_reduce(
        $anyOf,
        function($carry, $item) use ($data, $original) {
            return $carry
                || schema_valid($item, $data, $original);
        },
        false
    );    
}
