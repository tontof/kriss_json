<?php

function schema_valid_enum($schema, $data, $original) {
    $enum = $schema->enum;
    $result = false;
    foreach($enum as $item) {
        if ($data === $item) {
            $result = true;
        }
        if (is_object($item) && !is_numeric($data) && $data == $item) {
            $result = true;
        }
        if (is_numeric($item) && is_numeric($data) && $data == $item) {
            $result = true;
        }
    }
    return $result;
}
