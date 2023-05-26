<?php

function schema_valid_not($schema, $data, $original) {
    $not = $schema->not;
    $schema = clone $schema;
    unset($schema->not);
    return !schema_valid($not, $data, $original);
}
