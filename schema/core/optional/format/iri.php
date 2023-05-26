<?php

function schema_valid_format_iri($data) {
    include(__DIR__ . '/../../../core/inc/rfc.php');
    $regex = '%^'.$IRI.'$%u';
    return preg_match($regex, $data);
}
