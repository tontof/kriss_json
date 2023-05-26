<?php

function schema_valid_min_length($schema, $data, $original) {
    $minLength = $schema->minLength;
    return is_string($data)?$minLength <= mb_strlen($data):true;
}
