<?php

function schema_valid_dependent_schemas($schema, $data, $original) {
    $dependentSchemas = $schema->dependentSchemas;
    if (!is_object($data)) return true;
    return array_reduce(
        array_keys((array)$dependentSchemas),
        function ($carry, $item) use ($data, $dependentSchemas, $original) {
            return $carry
                && (isset($data->$item)
                    ?schema_valid($dependentSchemas->$item, $data, $original)
                    :true);
        },
        true
    );
}
