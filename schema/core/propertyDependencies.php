<?php

function schema_valid_property_dependencies($schema, $data, $original) {
    if (!is_object($data))  return true;
    $propertyDependencies = $schema->propertyDependencies;
    return array_reduce(
        array_keys((array)$propertyDependencies),
        function($result, $dependencies) use ($propertyDependencies, $data, $original) {
            return $result && array_key_exists($dependencies, (array)$data) && (!is_string($data->$dependencies) || array_reduce(
                array_keys((array)$propertyDependencies->$dependencies),
                function($result, $item) use ($propertyDependencies, $dependencies, $data, $original) {
                    if ($data->$dependencies === $item) {
                        if (is_bool($propertyDependencies->$dependencies->$item)) {
                            $result = $result && ($propertyDependencies->$dependencies->$item && $data->$dependencies === $item);
                        }
                        if (isset($propertyDependencies->$dependencies->$item->maxProperties)) {
                            $result = $result && (count(array_keys((array)$data)) <= $propertyDependencies->$dependencies->$item->maxProperties);
                        }
                        if (isset($propertyDependencies->$dependencies->$item->minProperties)) {
                            $result = $result && (count(array_keys((array)$data)) >= $propertyDependencies->$dependencies->$item->minProperties);
                        }
                    }
                    return $result;
                },
                true
            ));
        },
        true
    );
    return true;
}