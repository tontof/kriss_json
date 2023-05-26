<?php

include_once(__DIR__ . '/iri.php');

function schema_valid_format_iri_reference($data) {
    include(__DIR__ . '/../../inc/rfc.php');
    $regex = '%'.$irelativeRef.'%u';
    $result = schema_valid_format_iri($data);
    if (!$result) {
        preg_match($regex, $data, $match);
        $result = $match[0] === $data;
    }
    return $result;
}

