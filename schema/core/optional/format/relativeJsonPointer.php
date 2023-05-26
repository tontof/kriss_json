<?php

// https://www.ietf.org/archive/id/draft-handrews-relative-json-pointer-02.txt
function schema_valid_format_relative_json_pointer($data) {
    $escaped = "~[01]";
    $unescaped = "[\x{00}-\x{2E}\x{30}-\x{7D}\x{7F}-\x{10FFFF}]";
    $referenceToken = "(?:$unescaped|$escaped)*";
    $jsonPointer = "(/$referenceToken)*";

    $nonNegativeInteger = "(0|[1-9][0-9]*)";
    $relativeJsonPointer = "($nonNegativeInteger$jsonPointer|$nonNegativeInteger#)";

    $regex = '%^'.$relativeJsonPointer.'$%u';

    return preg_match($regex, $data);
}
