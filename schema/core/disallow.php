<?php

function schema_valid_disallow($schema, $data, $original) {
    $disallow = $schema->disallow;
    $schema = clone $schema;
    unset($schema->disallow);
    $schema->type = $disallow;
    return !schema_valid($schema, $data, $original);
}