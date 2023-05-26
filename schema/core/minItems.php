<?php

function schema_valid_min_items($schema, $data, $original) {
    $minItems = $schema->minItems;
    return is_array($data)?$minItems <= count($data):true;
}
