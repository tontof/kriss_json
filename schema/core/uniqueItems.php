<?php

include_once(__DIR__ . '/inc/identical.php');

function array_has_duplicate(array $array) : bool {
    do {
        $element = array_shift($array);
        foreach($array as $item) {
            if (valuesAreIdentical($element, $item)) {
                return true;
            }
        }
    } while (count($array) > 0);
    return false;
}

function schema_valid_unique_items($schema, $data, $original) {
    $uniqueItems = $schema->uniqueItems;
    if (!is_array($data)) return true;
    return $uniqueItems?!array_has_duplicate($data):true;
}
