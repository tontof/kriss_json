<?php

/* 
See also:
https://www.linuxjournal.com/article/9585
https://www.iamcal.com/publish/articles/php/parsing_email/
*/
function schema_valid_format_email($data) {
    include(__DIR__ . '/../../inc/rfc.php');
    return (preg_match('/^[^\.]([^@]+)[^\.]@([^@=]+)$/', $data) || preg_match('/".*"@[^@=]+/', $data))
       && (!preg_match('/\.\./', $data) || preg_match('/".*\.\..*"@[^@]+/', $data))
       && (!preg_match('/@\[.*\]/', $data) || preg_match("/@\[$IPv4address\]/", $data) || preg_match("/@\[IPv6:$IPv6address\]/", $data))
    ;
}
