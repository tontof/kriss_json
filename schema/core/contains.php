<?php

function schema_valid_contains($schema, $data, $original) {
    $contains = $schema->contains;
    if (isset($schema->minContains)) return true;
    if (!is_array($data)) return true;
    $r = array_reduce(
        (array)$data,
        function($result, $item) use ($contains, $original) {
            return $result
                || schema_valid($contains, $item, $original);
        },
        false
    );
    return $r;
}

function schema_valid_contains_with_object($schema, $data, $original) {
    $contains = $schema->contains;
    if (isset($schema->minContains)) return true;
    if (!is_array($data) && !is_object($data)) return true;
    $r = array_reduce(
        (array)$data,
        function($result, $item) use ($contains, $original) {
            return $result
                || schema_valid($contains, $item, $original);
        },
        false
    );
    return $r;
}
