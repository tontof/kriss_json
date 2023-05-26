<?php

// https://datatracker.ietf.org/doc/html/rfc3339#appendix-A
function schema_valid_format_duration($data) {
    $second = "\d+S";
    $minute = "\d+M($second)?";
    $hour = "\d+H($minute)?";
    $time = "T($hour|$minute|$second)";
    $day = "\d+D";
    $week = "\d+W";
    $month = "\d+M($day)?";
    $year = "\d+Y($month)?";
    $date = "($day|$month|$year)($time)?";
    $duration = "/^P($date|$time|$week)$/";
    return preg_match($duration, $data);
}