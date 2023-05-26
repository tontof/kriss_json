<?php

function schema_valid_exclusive_minimum($schema, $data, $original) {
    $emin = $schema->exclusiveMinimum;
    if (is_bool($emin)) {
        $min = $schema->minimum;
    } else {
	$min = $emin;
	$emin = true;
    }
    return is_numeric($data)?($emin?$min < $data: $min <= $data):true;
}
