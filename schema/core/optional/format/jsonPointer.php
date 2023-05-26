<?php

// https://www.rfc-editor.org/rfc/rfc6901
function schema_valid_format_json_pointer($data) {
    $escaped = "~[0|1]";
    $unescaped = "[\x{00}-\x{2E}|\x{30}-\x{7D}|\x{7F}-\x{10FFFF}]";
    $referenceToken = "($unescaped|$escaped)*";
    $jsonPointer = "(/$referenceToken)*";
    $regex = '!'.$jsonPointer.'!u';
    preg_match($regex, $data, $match);
    return $match[0] === $data;
}
