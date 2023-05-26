<?php

function schema_valid_content_media_type_application_json($data) {
    return true;
}

function schema_valid_content_media_type($schema, $data, $original) {
    return call_user_func('schema_valid_content_media_type_'.str_replace("/","_",$schema->contentMediaType), $data);
}
