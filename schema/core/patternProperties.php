<?php

function schema_valid_pattern_properties($schema, $data, $original) {
    $properties = isset($schema->properties)?array_keys((array)$schema->properties):[];
    $patternProperties = $schema->patternProperties;
    return array_reduce(
        array_keys((array)$patternProperties),
        function($result, $item) use ($patternProperties, $properties, $schema, $data, $original) {
            return $result
                && array_reduce(
                    array_keys((array)$data),
                    function($carry, $value) use ($patternProperties, $properties, $item, $schema, $data, $original) {
                        return $carry
                            && (preg_match('#'.$item.'#',$value) === 1
                                ?schema_valid($patternProperties->$item, $data->$value, $original)
                                :true
                        );
                    }, true
                );
        },
        true
    );    
}
