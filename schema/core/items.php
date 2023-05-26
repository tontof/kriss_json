<?php

function schema_valid_items($schema, $data, $original) {
    $items = $schema->items;
    if (!is_array($data)) return true;
    if ($items === false) {
        if (isset($schema->prefixItems) && count($data) <= count($schema->prefixItems)) {
             return true;
        }
    }
    if (isset($schema->prefixItems)) {
        $data = array_slice($data, count($schema->prefixItems));
    }
    if (is_array($items)) {
        $valid = [];
        foreach($data as $key => $d) {
            $valid[] = [
                "schema" => isset($items[$key])?$items[$key]:[],
                "data" => $d
            ];
        }
        return array_reduce(
            $valid,
            function($result, $item) use ($original) {
                return $result
                    && schema_valid($item["schema"], $item["data"], $original);
            },
            true
        );
    }
    return array_reduce(
        $data,
        function($result, $item) use ($items, $original) {
            return $result
                && schema_valid($items, $item, $original);
        },
        true
    );
}
