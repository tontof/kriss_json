<?php

include_once(__DIR__ . '/hostname.php');

// https://www.rfc-editor.org/rfc/rfc5892#section-2.6
function schema_valid_format_idn_hostname($data) {
    if (preg_match('![\x{0640}\x{07fa}\x{302e}\x{302f}\x{3031}-\x{3035}\x{303b}]!u', $data)) {
        return false;
    }
    // MIDDLE DOT
    if (preg_match('!\x{00b7}!u', $data)) {
        if (!preg_match('!l\x{00b7}l!u', $data)) {
            return false;
        }
    }
    // https://en.wikipedia.org/wiki/Greek_script_in_Unicode
    if (preg_match('!\x{0375}!u', $data)) {
        if (!preg_match('!\x{0375}[\x{0370}-\x{03ff}]+!u', $data)) {
            return false;
        }
    }
    // https://en.wikipedia.org/wiki/Unicode_and_HTML_for_the_Hebrew_alphabet
    if (preg_match('!\x{05f3}!u', $data)) {
        if (!preg_match('![\x{0590}-\x{05ff}\x{fb1d}-\x{fb4f}]+\x{05f3}!u', $data)) {
            return false;
        }
    }
    if (preg_match('!\x{05f4}!u', $data)) {
        if (!preg_match('![\x{0590}-\x{05ff}\x{fb1d}-\x{fb4f}]+\x{05f4}!u', $data)) {
            return false;
        }
    }
    // KATAKANA MIDDLE DOT
    // https://en.wikipedia.org/wiki/Hiragana_(Unicode_block)
    // https://en.wikipedia.org/wiki/Katakana_(Unicode_block)
    if (preg_match('!\x{30fb}!u', $data)) {
        $hiragana = '\x{3040}-\x{309f}';
        $katakana = '\x{30a0}-\x{30fa}\x{30fc}-\x{30ff}';
        $han = '\x{4e00}-\x{9fff}';
        if (!preg_match("![$hiragana$katakana$han]!u", $data)) {
            return false;
        }
    }
    // ARABIC-INDIC DIGITS
    if (preg_match('![\x{0660}-\x{0669}]!u', $data)) {
        if (preg_match('![\x{06f0}-\x{06f9}]!u', $data)) {
            return false;
        }
    }
    // ZERO WIDTH JOINER
    if (preg_match('!\x{200d}!u', $data)) {
        // https://www.compart.com/en/unicode/combining/9
        if (!preg_match('![\x{094d}\x{09cd}\x{0a4d}\x{0acd}\x{0b4d}\x{0bcd}\x{0c4d}\x{0ccd}\x{0d3b}\x{0d3c}\x{0d4d}\x{0dca}\x{0e3a}\x{0eba}\x{0f84}\x{1039}\x{103a}\x{1714}\x{1734}\x{17d2}\x{1a60}\x{1b44}\x{1baa}\x{1bab}\x{1bf2}\x{1bf3}\x{2d7f}\x{a806}\x{a82c}\x{a8c4}\x{a953}\x{a9c0}\x{aaf6}\x{abed}\x{10a3f}\x{11046}\x{1107f}\x{110b9}\x{11133}\x{11134}\x{111c0}\x{11235}\x{112ea}\x{1134d}\x{11442}\x{114c2}\x{115bf}\x{1163f}\x{116b6}\x{1172b}\x{11839}\x{1193d}\x{1193e}\x{119e0}\x{11a34}\x{11a47}\x{11a99}\x{11c3f}\x{11d44}\x{11d45}\x{11d97}]\x{200d}!u', $data)) {
            return false;
        }        
    }
    // php-intl
    $data = idn_to_ascii($data);
    return schema_valid_format_hostname($data);
}

