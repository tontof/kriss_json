<?php

// https://www.rfc-editor.org/rfc/rfc3987#section-2.2
$subDelims     = "[!$&'\(\)*+,;=]";
$genDelims     = "[:/\?#\[\]@]";
$reserved      = "(?:$genDelims|$subDelims)";
$alpha         = "[a-zA-Z]";
$digit         = "[0-9]";
$hexdig        = "(?:$digit|[a-fA-F])";
$pctEncoded    = "\%$hexdig$hexdig";
$unreserved    = "(?:$alpha|$digit|[-\._~])";
$pchar         = "(?:$unreserved|$pctEncoded|$subDelims|[:@])";
$fragment      = "(?:$pchar|/|\?)*";
$query         = "(?:$pchar|/|\?)*";
$IPvFuture     = "v$hexdig\.(?:$unreserved|$subDelims|:)";
$decOctet      = "(?:$digit|[1-9]$digit|1$digit$digit|2[0-4]$digit|25[0-5])";
$IPv4address   = "$decOctet\.$decOctet\.$decOctet\.$decOctet";
$h16           = "$hexdig{1,4}";
$ls32          = "(?:$h16:$h16|$IPv4address)";
$IPv6address   = "(?:($h16:){6}$ls32".
               "|::($h16:){5}$ls32".
               "|($h16)?::($h16:){4}$ls32".
               "|((($h16:){0,1})?$h16)?::($h16:){3}$ls32".
               "|((($h16:){0,2})?$h16)?::($h16:){2}$ls32".
               "|((($h16:){0,3})?$h16)?::$h16:$ls32".
               "|((($h16:){0,4})?$h16)?::$ls32".
               "|((($h16:){0,5})?$h16)?::$h16".
               "|((($h16:){0,6})?$h16)?::)"
               ;

$IPliteral     = "\[(?:$IPv6address|$IPvFuture)\]";
$regName       = "(?:$unreserved|$pctEncoded|$subDelims)*";

$userinfo      = "(?:$unreserved|$pctEncoded|$subDelims|:)*";
$host          = "(?:$IPliteral|$IPv4address|$regName)";
$port          = "\d*";
$scheme        = "$alpha(?:$alpha|$digit|\+|-|\.)*";

$iprivate      = "[\x{e000}-\x{f8ff}\x{f0000}-\x{ffffd}\x{100000}-\x{10fffd}]";

$ucschar       = "[\x{00a0}-\x{d7ff}\x{f900}-\x{fdcf}\x{fdf0}-\x{ffef}".
               "\x{10000}-\x{1fffd}\x{20000}-\x{2fffd}\x{30000}-\x{3fffd}".
               "\x{40000}-\x{4fffd}\x{50000}-\x{5fffd}\x{60000}-\x{6fffd}".
               "\x{70000}-\x{7fffd}\x{80000}-\x{8fffd}\x{90000}-\x{9fffd}".
               "\x{a0000}-\x{afffd}\x{b0000}-\x{bfffd}\x{c0000}-\x{cfffd}".
               "\x{d0000}-\x{dfffd}\x{e1000}-\x{efffd}]";

$iunreserved   = "(?:$alpha|$digit|-|\.|_|~|$ucschar)";
$ipchar        = "(?:$iunreserved|$pctEncoded|$subDelims|:|@)";
$iquery        = "(?:$ipchar|$iprivate|/|\?)*";
$ifragment     = "(?:$ipchar|/|\?)*";

$isegment      = "(?:$ipchar)*";
$isegmentNz    = "(?:$ipchar)+";
$isegmentNzNc  = "(?:$iunreserved|$pctEncoded|$subDelims|@)+";

$ipathEmpty    = "$ipchar?";
$ipathAbempty  = "(?:/$isegment)*";
$ipathAbsolute = "/(?:$isegmentNz(?:/$isegment)*)";
$ipathNoscheme = "$isegmentNzNc(?:/$isegment)*";
$ipathRootless = "$isegmentNz(?:/$isegment)*";

$iregName      = "(?:$iunreserved|$pctEncoded|$subDelims)*";
$ihost         = "(?:$IPliteral|$IPv4address|$iregName)";
$iuserinfo     = "(?:$iunreserved|$pctEncoded|$subDelims|:)*";

$iauthority    = "(?:$iuserinfo@)?$ihost(?::$port)?";
$irelativePart = "(?://$iauthority$ipathAbempty|$ipathAbsolute|$ipathNoscheme|$ipathEmpty)";
$irelativeRef  = "$irelativePart(?:\?$iquery)?(?:#$ifragment)?";

$ihierPart     = "(?://$iauthority$ipathAbempty|$ipathAbsolute|$ipathRootless|$ipathEmpty)";

$absoluteIRI   = "$scheme:$ihierPart(?:\?$iquery)?";
$IRI           = "$scheme:$ihierPart(?:\?$iquery)?(?:#$ifragment)?";

// https://www.rfc-editor.org/rfc/rfc3986#appendix-A
$authority     = "(?:$userinfo@)?$host(?::$port)?";

$segment       = "(?:$pchar)*";
$segmentNz     = "(?:$pchar)+";
$segmentNzNc   = "(?:$unreserved|$pctEncoded|$subDelims|@)+";

$pathAbempty   = "(?:/$segment)*";
$pathAbsolute  = "/(?:$segmentNz(?:/$segment)*)?";
$pathNoscheme  = "$segmentNzNc(?:/$segment)*";
$pathRootless  = "$segmentNz(?:/$segment)*";
$pathEmpty     = "";

$relativePart  = "(?://$authority$pathAbempty|$pathAbsolute|$pathNoscheme|$pathEmpty)";
$relativeRef   = "$relativePart(?:\?$query)?(?:#$fragment)?";

$hierPart      = "(?://$authority$pathAbempty|$pathAbsolute|$pathRootless|$pathEmpty)";

$URI           = "$scheme:$hierPart(?:\?$query)?(?:#$fragment)?";
$URIreference  = "(?:$URI|$relativeRef)";

$absoluteURI   = "$scheme:$hierPart(?:\?$query)?";

