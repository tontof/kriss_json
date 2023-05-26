<?php

function schema_valid_unevaluated_items($schema, $data, $original) {
    $unevaluatedItems = $schema->unevaluatedItems;
    if ($unevaluatedItems === true) return true;
    if (isset($schema->items)) return true;
    $slice = 0;
    if (isset($schema->prefixItems)) {
        $slice = count($schema->prefixItems);
    }
    if (isset($schema->allOf)) {
        if (array_reduce(
            $schema->allOf,
            function($carry, $item) {
                return $carry || isset($item->items) || (isset($item->unevaluatedItems) && $item->unevaluatedItems);
            },
            false
        )) {
            return true;
        }
        $maxPref = array_reduce(
            $schema->allOf,
            function($carry, $item) {
                return (isset($item->prefixItems) && (count($item->prefixItems) > $carry))
                 ?count($item->prefixItems)
                 :$carry;
            },
            0
        );
        if ($maxPref > $slice) $slice = $maxPref;
    }
    if (isset($schema->anyOf)) {
        $anyOf = array_reduce(
            $schema->anyOf,
            function($carry, $item) use ($data, $original) {
                if (schema_valid($item, $data, $original)) {
                    return array_merge($carry, [$item]);
                }
                
                return $carry;
            },
            []
        );
        $maxPref = array_reduce(
            $anyOf,
            function($carry, $item) {
                return (isset($item->prefixItems) && (count($item->prefixItems) > $carry))
                 ?count($item->prefixItems)
                 :$carry;
            },
            0
        );
        if ($maxPref > $slice) $slice = $maxPref;
    }
    if (isset($schema->oneOf)) {
        $oneOf = array_reduce(
            $schema->oneOf,
            function($carry, $item) use ($data, $original){
                if (schema_valid($item, $data, $original)) {
                    return $item;
                }
                
                return $carry;
            },
            false
        );
        if (isset($oneOf->prefixItems) && (count($oneOf->prefixItems) > $slice)) $slice = count($oneOf->prefixItems);
    }
    if (isset($schema->if)) {
        if (schema_valid($schema->if, $data, $original)) {
            if (isset($schema->then) && isset($schema->then->prefixItems) && (count($schema->then->prefixItems) > $slice)) {
                $slice = count($schema->then->prefixItems);
            }            
        } else {
            if (isset($schema->else) && isset($schema->else->prefixItems) && (count($schema->else->prefixItems) > $slice)) {
                $slice = count($schema->else->prefixItems);
            }            
        }
        
    }
    if (is_array($data)) {
        $data = array_slice($data, $slice);
        return array_reduce(
            $data,
            function($result, $item) use ($unevaluatedItems, $original) {
                return $result
                    && schema_valid($unevaluatedItems, $item, $original);
            },
            true
        );
    }
    return true;
}
