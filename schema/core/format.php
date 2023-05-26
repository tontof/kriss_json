<?php

function schema_valid_format($schema, $data, $original) {
    return !is_string($data) || call_user_func(schema_function_valid('format_'.$schema->format, $original), $data);
}