<?php

// https://stackoverflow.com/a/4694816
function schema_valid_format_hostname($data) {
    return (preg_match("/^([a-z\d](-*[a-z\d])*)(\.([a-z\d](-*[a-z\d])*))*$/i", $data) //valid chars check
            && preg_match("/^.{1,253}$/", $data) //overall length check
            && preg_match("/^[^\.]{1,63}(\.[^\.]{1,63})*$/", $data)); //length of each label
}
