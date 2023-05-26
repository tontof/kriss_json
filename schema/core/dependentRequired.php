<?php

function schema_valid_dependent_required($schema, $data, $original) {
    $dependentRequired = $schema->dependentRequired;
    if (!is_object($data)) return true;
    return array_reduce(
        array_keys((array)$dependentRequired),
        function ($carry, $item) use ($data, $dependentRequired) {
            return $carry
                && (isset($data->$item)
                    ?array_reduce(
                        $dependentRequired->$item,
                        function($carry, $item) use ($data){
                            return $carry && isset($data->$item);
                        },
                        true)
                    :true);
        },
        true
    );
}
