<?php

function schema_valid_exclusive_maximum($schema, $data, $original) {
    $emax = $schema->exclusiveMaximum;
    if (is_bool($emax)) {
        $max = $schema->maximum;
    } else {
	$max = $emax;
	$emax = true;
    }
    return is_numeric($data)?($emax?$data < $max:$data <= $max):true;
}
