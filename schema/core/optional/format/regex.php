<?php

function schema_valid_format_regex($data) {
    return @preg_match("/".str_replace("/","\/",$data)."/",null) !== false;
}
