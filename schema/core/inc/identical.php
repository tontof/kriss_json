<?php

// https://www.php.net/manual/en/language.oop5.object-comparison.php#121105
function valuesAreIdentical($v1, $v2): bool {
    $type1 = gettype($v1);
    $type2 = gettype($v2);

    if($type1 !== $type2){
        return false;
    }

    switch($type1){
    case 'boolean':
    case 'integer':
    case 'double':
    case 'string':
        //Do strict comparison here.
        if($v1 !== $v2){
            return false;
        }
        break;
    case 'array':
        $bool = arraysAreIdentical($v1, $v2);
        if($bool===false){
            return false;
        }
        break;
    case 'object':
        $bool = objectsAreIdentical($v1,$v2);
        if($bool===false){
            return false;
        }
        break;
        
    case 'NULL':
        //Since both types were of type NULL, consider their "values" equal.
        break;
        
    case 'resource':
        //How to compare if at all?
        break;
        
    case 'unknown type':
        //How to compare if at all?
        break;
    } //end switch
    //All tests passed.
    return true;
}

function objectsAreIdentical($o1, $o2): bool {
    foreach(array_merge(array_keys((array)$o1),array_keys((array)$o2)) as $key) {
        if (!isset($o2->$key) || !isset($o1->$key)) {
            return false;
        }
        if (!valuesAreIdentical($o1->$key, $o2->$key)) {
            return false;
        }
    }
    return true;
}

function arraysAreIdentical(array $arr1, array $arr2): bool {
    $count = count($arr1);
    //Require that they have the same size.
    if(count($arr2) !== $count){
        return false;
    }
    //Require that they have the same keys.
    $arrKeysInCommon = array_intersect_key($arr1, $arr2);
    if(count($arrKeysInCommon)!== $count){
        return false;
    }
    //Require that their keys be in the same order.
    $arrKeys1 = array_keys($arr1);
    $arrKeys2 = array_keys($arr2);
    foreach($arrKeys1 as $key=>$val){
        if($arrKeys1[$key] !== $arrKeys2[$key]){
            return false;
        }
    }
    //They do have same keys and in same order.
    foreach($arr1 as $key=>$val){
        $bool = valuesAreIdentical($arr1[$key], $arr2[$key]);
        if($bool===false){
            return false;
        }
    }
    //All tests passed.
    return true;
}
