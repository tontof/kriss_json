<?php

function is_absolute($path) {
    return $path[0] === "/" || strpos($path, "://") !== false || strpos($path, "urn:") !== false;
}

function compute_ref_schema_base($base, $relative) {
    if (empty($base)) {
        return $relative;
    }
    if (empty($relative)) {
        return $base;
    }
    if (is_absolute($relative)) {
        return $relative;
    }
    if ($relative[0] === "#") {
        return str_replace("##","#",$base.$relative);
    }
    if (substr($base, -1) !== "/") {
        $base = dirname($base)."/";
    }
    $hash = explode("#", $relative);
    $hash[0] = $hash[0].(substr($hash[0], -1) === "/"?"/":"");
    $relative = implode("#", $hash);
    return $base.$relative;
}

function compute_ref_schema(&$schema, $id = "") {
    if (isset($schema->{'$ref'})) {
        if (empty($id)) {
            if (isset($schema->id)) {
                $id = $schema->id;
            }
            if (isset($schema->{'$id'})) {
                $id = $schema->{'$id'};
            }
        }
        $schema->{'$ref'} = compute_ref_schema_base($id, $schema->{'$ref'});
    }
    if (isset($schema->id)) {
        $schema->{'$id'} = $schema->id;
        unset($schema->id);
    }
    if (isset($schema->{'$id'})) {
        $schema->{'$id'} = compute_ref_schema_base($id, $schema->{'$id'});
        $id = $schema->{'$id'};
    }
    if (is_object($schema) || is_array($schema)) { 
        foreach($schema as $key => $value) {
            if (!in_array($key, ['enum', 'properties'], true)) {
                if (is_object($schema)) {
                    $schema->$key = compute_ref_schema($value, $id);
                } else {
                    $schema[$key] = compute_ref_schema($value, $id);
                }
            }
            if ($key === 'properties') {
                foreach($schema->properties as $prop => $propValue) {
                    $schema->properties->$prop = compute_ref_schema($propValue, $id);
                }
            }
        }
    }
    return $schema;
}
