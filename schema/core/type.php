<?php

function schema_valid_type_integer($data) {
    if (is_int($data) || is_float($data)) {
        return ((int)$data) == $data;        
    }
    return false;
}

function schema_valid_type_number($data) {
    return (is_int($data) || is_float($data));
}

function schema_valid_type_string($data) {
    return is_string($data);
}

function schema_valid_type_object($data) {
    return is_object($data);
}

function schema_valid_type_array($data) {
    return is_array($data);
}

function schema_valid_type_boolean($data) {
    return is_bool($data);
}

function schema_valid_type_null($data) {
    return is_null($data);
}

function schema_valid_type_any($data) {
    return true;
}

function schema_valid_type($schema, $data, $original) {
    $type = $schema->type;
    if (is_string($type)) {
        return call_user_func('schema_valid_type_'.$type, $data);
    }
    if (is_array($type)) {
        return array_reduce($type, function($result, $item) use ($schema, $data, $original) { $schema = clone $schema; $schema->type = $item; return $result || schema_valid_type($schema, $data, $original); }, false);
    }
    return schema_valid($type, $data, $original);
}