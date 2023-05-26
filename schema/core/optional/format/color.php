<?php

// https://www.w3.org/TR/2007/CR-CSS21-20070719/syndata.html#value-def-color
function schema_valid_format_color($data) {
    $color = "(?:aqua|black|blue|fuchsia|gray|green|lime|maroon|navy|olive|orange|purple|red|silver|teal|white|yellow|#[a-fA-F0-9]{3}|#[a-fA-F0-9]{6})";
    
    return preg_match('%^'.$color.'$%', $data);
}
