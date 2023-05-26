<?php

function schema_valid_dependencies($schema, $data, $original) {
    $dependencies = $schema->dependencies;
    $valid = true;
    if (is_object($data)) {
        foreach($dependencies as $key => $s) {
            if (is_string($s)) {
                $s = [$s];
            }
            if (is_bool($s)) {
                $valid = $valid && ($s || (!$s && !array_key_exists($key, (array)$data)));
            }
            if (array_key_exists($key, (array)$data) && is_array($s)) {
                $valid = $valid && array_reduce($s, function($carry, $item) use ($data) {
                        return $carry && array_key_exists($item, (array)$data);
                    }, $valid);
            }
            if (array_key_exists($key, (array)$data) && is_object($s)) {
                $valid = $valid && schema_valid($s, $data, $original);
            }
        }
    }
    return $valid;
}
