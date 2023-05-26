<?php

function schema_valid_max_length($schema, $data, $original) {
    $maxLength = $schema->maxLength;
    return is_string($data)?mb_strlen($data) <= $maxLength:true;
}
