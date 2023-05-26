<?php

function schema_valid_format_date_time_format($date, $formats)
{
    $date = str_replace('t','T', $date);
    $date = str_replace('z','Z', $date);
    return array_reduce($formats, function($result, $format) use ($date) {
            if (preg_match('/[+-](\d\d:\d\d)/', $date, $match)) {
                $time = DateTime::createFromFormat('H:i', $match[1]);
                if ($time->format('H:i') !== $match[1]) {
                    return false;
                }
            }
            if (strpos($format, '23:59:60') !== false && strpos($date, ':60') !== false) {
                $datetime = DateTime::createFromFormat(str_replace('23:59:60', 'H:i:s', $format), $date);
                if ($datetime) {
                    if (strpos($format, "P")) {
                        $datetime->setTimezone(new DateTimeZone('UTC'));
                    }
                    if ($datetime->format('H:i:s') === '00:00:00') {
                        $result = true;
                    }
                }
            } else {
                $datetime = DateTime::createFromFormat($format, $date);
                if ($datetime) {
                    $datetime = $datetime->format($format);
                    // remove trailing 0 for u format
                    $datetime = preg_replace('/\.([0-9]*[1-9])0*([Z+-])/','.\1\2', $datetime);
                }
            }
            return $result || ($datetime === $date);
        }, false);
}
