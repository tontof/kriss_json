<?php

function schema_valid_max_items($schema, $data, $original) {
    $maxItems = $schema->maxItems;
    return is_array($data)?count($data) <= $maxItems:true;
}
