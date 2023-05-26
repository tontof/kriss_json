<?php

function schema_valid_one_of($schema, $data, $original) {
    $oneOf = $schema->oneOf;
    return array_reduce(
        $oneOf,
        function($carry, $item) use ($data, $original) {
            return $carry + (int)schema_valid($item, $data, $original);
        },
        0
    ) === 1;
}
