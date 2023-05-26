<?php

function schema_valid_extends($schema, $data, $original) {
    $extends = $schema->extends;
    $schema = clone $schema;
    unset($schema->extends);
    if (!is_array($extends)) {
        $extends = [$extends];
    }
    foreach($extends as $extend) {
        unset($extend->items);
        foreach($extend as $key => $value)
            if (isset($schema->$key)) {
                $schema->$key = (object) array_merge((array) $schema->$key, (array) $value);
            } else {
                $schema->$key = $value;
            }
    }
    return schema_valid($schema, $data, $original);
}
