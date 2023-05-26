<?php

function schema_valid_if($schema, $data, $original) {
    $if = $schema->if;
    $then = isset($schema->then)?$schema->then:null;
    $else = isset($schema->else)?$schema->else:null;
    if (!isset($then) && !isset($else)) return true;
    return schema_valid($if, $data, $original)
        ?schema_valid($then, $data, $original)
        :schema_valid($else, $data, $original);
}
