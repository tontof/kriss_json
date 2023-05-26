<?php

function schema_valid_min_contains($schema, $data, $original) {
    $minContains = $schema->minContains;
    if (!isset($schema->contains)) return true;
    if (isset($schema->maxContains) && $schema->maxContains < $minContains) return false;
    if ($minContains == 0) return true;
    if (is_array($data)) {
        return $minContains <= array_reduce(
            $data,
            function($result, $item) use ($schema, $original) {
                return $result + ((int)schema_valid($schema->contains, $item, $original));
            },
            0);
    }
    return true;
}
