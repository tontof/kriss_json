<?php

// https://github.com/rize/UriTemplate/blob/master/src/Rize/UriTemplate/Parser.php
function schema_valid_format_uri_template($data) {
    $parts = preg_split('#(\{[^\}]+\})#', $data, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);
    return array_reduce(
        $parts,
	function($carry, $part) {
		if (strpos($part, '{') === 0 && strpos($part, '}') === strlen($part)-1) {
			$test = preg_match('#(?:[A-z0-9_\.]|%[0-9a-fA-F]{2})#', substr($part, 1, -1)); 
		} else {
			$test = strpos($part, '{') === false && strpos($part, '}') === false;
		}
            return $carry && $test;
        },
        true
    );
    return true;
}
