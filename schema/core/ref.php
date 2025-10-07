<?php

function remote($url) {
    $parse = parse_url($url);
    if (!array_key_exists('host', $parse)) {
        return [];
    }
    $file = substr($parse['path'], 1); // remove first / from path
    if ($parse['host'] == "localhost") {
        $file = __DIR__ . "/../tests/JSON-Schema-Test-Suite/remotes/".$file;
    } else {
        $file = __DIR__ . "/../remotes/".$file;
    }
    if (file_exists($file) && !is_dir($file)) {
        $schema = file_get_contents($file);
    } else {
        if ($parse['host'] == "json-schema.org") {
            if ($url === "https://json-schema.org/draft/next/schema") {
                $url = "https://json-schema.org/draft/2020-12/schema";
            }
            $schema = file_get_contents($url);
            if (!is_dir(dirname($file))) {
                mkdir(dirname($file), 0777, true);
            }
            file_put_contents($file, $schema);
        } else {
            $schema = "";
        }
    }
    return json_decode($schema);
}

function schema_from_anchor($schema, $anchor) {
    if ($anchor === "#") {
        return $schema;
    }
    return schema_search($schema, substr($anchor, 1), '$anchor');
}

//https://www.php.net/manual/fr/function.parse-url.php#106731
function unparse_url($parsed_url) {
    $scheme   = isset($parsed_url['scheme']) ? $parsed_url['scheme'] . '://' : '';
    $host     = isset($parsed_url['host']) ? $parsed_url['host'] : '';
    $port     = isset($parsed_url['port']) ? ':' . $parsed_url['port'] : '';
    $user     = isset($parsed_url['user']) ? $parsed_url['user'] : '';
    $pass     = isset($parsed_url['pass']) ? ':' . $parsed_url['pass']  : '';
    $pass     = ($user || $pass) ? "$pass@" : '';
    $path     = isset($parsed_url['path']) ? $parsed_url['path'] : '';
    $query    = isset($parsed_url['query']) ? '?' . $parsed_url['query'] : '';
    $fragment = isset($parsed_url['fragment']) ? '#' . $parsed_url['fragment'] : '';
    return "$scheme$user$pass$host$port$path$query$fragment";
}

function schema_from_abs($schema, $ref) {
    $parsed = parse_url($schema->{'$id'});
    $parsed['path'] = $ref;
    return schema_search($schema, unparse_url($parsed), '$id');
}

function schema_from_hash($schema, $hash) {
    $refs = explode('/', $hash);
    array_shift($refs); // remove root #
    if (empty($refs)) {
        return schema_from_anchor($schema, $hash);
    }
    return array_reduce(
            $refs,
            function($carry, $item) {
                $item = str_replace('~0', '~', $item);
                $item = str_replace('~1', '/', $item);
                if (is_array($carry) && isset($carry[$item])) {
                    return $carry[$item];
                }
                if (is_object($carry) && isset($carry->$item)) {
                    return $carry->$item;
                }
                return [];
            },
            $schema
        );
}

function schema_from_ref($schema, $ref, &$original) {
    // search for id
    $result = schema_from_id($original['schema'], $ref);
    if (!empty($result)) return $result;
    // search for id without hash
    $hash = explode('#', $ref);
    if (count($hash) > 1 && !empty($hash[0])) {
        $result = schema_from_id($original['schema'], $hash[0]);
        if (!empty($result)) {
            $result = schema_from_hash($result, "#".$hash[1]);
        }
    }
    if (!empty($result)) return $result;
    // ref starts with hash
    if ($ref[0] === "#") {
        return schema_from_hash($original['schema'], $ref);
    }
    // ref starts with / abs
    if ($ref[0] === "/") {
        return schema_from_abs($original['schema'], $ref);
    }
    // remote
    $hash = explode('#', $ref);
    $result = remote($ref);
    if (!empty($result)) {
        $result = compute_ref_schema($result, $hash[0]);
        $original['schema'] = $result;
    }
    if (count($hash) > 1) {
        $result = schema_from_hash($result, "#".$hash[1]);
    }
    return $result;
}

function schema_search($schema, $search, $attr) {
    if (isset($schema->$attr)) {
        $cmp = $schema->$attr;
        if ($attr == '$id' && is_string($cmp)) {
            $cmp = urldecode($cmp);
        }
        if ($cmp == $search) {
            return $schema;
        }
    }
    if (is_object($schema)) {
        foreach($schema as $key => $value) {
            $result = schema_search($value, $search, $attr);
            if (!empty($result)) {
                return $result;
            }
        }
        if (isset($schema->allOf) && is_array($schema->allOf)) {
            foreach($schema->allOf as $all) {
                if ($attr !== '$anchor' || !isset($all->{'$id'})) {
                    $result = schema_search($all, $search, $attr);
                    if (!empty($result)) {
                        return $result;
                    }
                }
            }
        }
    }
    return [];
}

function schema_from_id($schema, $id) {
    return schema_search($schema, $id, '$id');
}

function schema_valid_ref($schema, $data, $original) {
    $ref = urldecode($schema->{'$ref'});
    $schema = schema_from_ref($schema, $ref, $original);
    return schema_valid($schema, $data, $original);
}
