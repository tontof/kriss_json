<?php

function schema_valid_maximum($schema, $data, $original) {
    $maximum = $schema->maximum;
    return is_numeric($data)?$data <= $maximum:true;
}
