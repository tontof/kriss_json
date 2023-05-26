<?php

// https://datatracker.ietf.org/doc/html/rfc4122#section-3
function schema_valid_format_uuid($data) {
    $data = strtolower($data);
    return preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/', $data);
}
