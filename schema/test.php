<?php
// KrISS json: a simple and smart (or stupid) json schema validator
// Copyleft (ɔ) - Tontof - https://tontof.net
// use KrISS json at your own risk

include_once(__DIR__ . '/json.php');

$acceptedDirs = ['draft3','draft4','draft6','draft7','draft2019-09','draft2020-12','draft-next'];
$dirs = [];
$debug = false;
if ($argc > 1) {
    foreach($argv as $arg) {
        if (in_array($arg, $acceptedDirs)) {
            $dirs[] = $arg;
        }
        if ($arg == "-d") {
            $debug = true;
        }
    }
}
if (empty($dirs)) {
    $dirs = $acceptedDirs;
}
$results = [];
foreach($dirs as $dir) {
    $filenames = array_merge(
        glob(__DIR__ . "/tests/JSON-Schema-Test-Suite/tests/$dir/*.json"),
        glob(__DIR__ . "/tests/JSON-Schema-Test-Suite/tests/$dir/optional/format/*.json"),
    );
    $result = 0;
    $resultFile = 0;
    $total = 0;
    foreach($filenames as $filename) {
        $file = file_get_contents($filename);
        $file = json_decode($file);
        $checkFile = true;
        foreach($file as $content) {
            $schema = $content->schema;
            $tests = $content->tests;
            $total += count($tests);
            $check = true;
            foreach($tests as $test) {
                $data = $test->data;
                $valid = $test->valid;
                $check = $valid === json_schema($schema, $data, $dir);
                $result += $check?1:0;
                if (!$check) {
                    $checkFile = false;
                }
            }
        }
        if ($checkFile) {
            $resultFile++;
        } else {
            if ($debug) {
                echo $filename."\n";
            }
        }
    }
    $results[$dir] = [
        "tests" => sprintf("% 9s", "$result/$total"),
        "files" => sprintf("% 9s", $resultFile."/".count($filenames))
    ];
}
echo "tests suite:\tnb tests\tnb files\n";
foreach($dirs as $dir) {
    echo "$dir: \t".$results[$dir]["tests"]."\t".$results[$dir]["files"]."\n";
}
