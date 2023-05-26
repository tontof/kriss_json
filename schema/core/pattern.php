<?php

function schema_valid_pattern($schema, $data, $original) {
    $pattern = $schema->pattern;
    if (is_string($data) ) {
        return preg_match('%'.$pattern.'%',$data) === 1;
    }
    return true;
}
