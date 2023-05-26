<?php

function schema_valid_multiple_of($schema, $data, $original) {
    $multipleOf = $schema->multipleOf;
    if (!is_numeric($data)) return true;
    $divider = $data / $multipleOf;
    return $divider == (int)$divider;
}
