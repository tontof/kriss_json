<?php

function schema_valid_minimum($schema, $data, $original) {
    $minimum = $schema->minimum;
    return is_numeric($data)?$minimum <= $data:true;
}
