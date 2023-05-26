<?php

function schema_valid_divisible_by($schema, $data, $original) {
    $divisibleBy = $schema->divisibleBy;
    if (!is_numeric($data) || !is_numeric($divisibleBy)) {
        return true;
    }
    return $divisibleBy !== 0 && ($data === 0 || (($data / $divisibleBy) == (int)($data / $divisibleBy)));
}