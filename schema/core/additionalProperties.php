<?php

function schema_valid_is_additional_properties($schema, $property) {
    $properties = isset($schema->properties)?array_keys((array)$schema->properties):[];
    $patternProperties = isset($schema->patternProperties)?array_keys((array)$schema->patternProperties):[];
    $result = true;
    if (in_array($property, $properties) || (!empty($patternProperties) && preg_match('#'.implode('|', $patternProperties).'#',$property) === 1)) {
        $result = false;
    }
    return $result;
}

function schema_valid_additional_properties($schema, $data, $original) {
    $properties = isset($schema->properties)?array_keys((array)$schema->properties):[];
    $patternProperties = isset($schema->patternProperties)?array_keys((array)$schema->patternProperties):[];
    $additionalProperties = $schema->additionalProperties;
    if (!is_object($data)) return true;
    return array_reduce(
        array_keys((array)$data),
        function($result, $value) use ($additionalProperties, $properties, $schema, $data, $original) {
            return $result
                && (schema_valid_is_additional_properties($schema, $value)
                    ?schema_valid($additionalProperties, $data->$value, $original)
                    :true);
        },
        true
    );    
}
