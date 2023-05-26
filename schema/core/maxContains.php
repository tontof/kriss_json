<?php

function schema_valid_max_contains($schema, $data, $original) {
    $maxContains = $schema->maxContains;
    if (!isset($schema->contains)) return true;
    if (empty((array)$data)) return false;
    if (isset($schema->minContains) && $schema->minContains > $maxContains) return false;
    if (is_array($data) | is_object($data)) {
        return array_reduce(
            (array)$data,
            function($result, $item) use ($schema, $original) {
                return $result + ((int)schema_valid($schema->contains, $item, $original));
            },
            0) <= $maxContains;
    }
    return true;
}
