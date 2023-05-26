<?php

include_once(__DIR__ . '/core/inc/computeRef.php');
include_once(__DIR__ . '/core/additionalItems.php');
include_once(__DIR__ . '/core/additionalProperties.php');
include_once(__DIR__ . '/core/allOf.php');
include_once(__DIR__ . '/core/anyOf.php');
include_once(__DIR__ . '/core/const.php');
include_once(__DIR__ . '/core/contains.php');
include_once(__DIR__ . '/core/content.php');
include_once(__DIR__ . '/core/dependencies.php');
include_once(__DIR__ . '/core/dependentRequired.php');
include_once(__DIR__ . '/core/dependentSchemas.php');
include_once(__DIR__ . '/core/disallow.php');
include_once(__DIR__ . '/core/divisibleBy.php');
include_once(__DIR__ . '/core/enum.php');
include_once(__DIR__ . '/core/exclusiveMaximum.php');
include_once(__DIR__ . '/core/exclusiveMinimum.php');
include_once(__DIR__ . '/core/extends.php');
include_once(__DIR__ . '/core/format.php');
include_once(__DIR__ . '/core/ifThenElse.php');
include_once(__DIR__ . '/core/items.php');
include_once(__DIR__ . '/core/maxContains.php');
include_once(__DIR__ . '/core/maximum.php');
include_once(__DIR__ . '/core/maxItems.php');
include_once(__DIR__ . '/core/maxLength.php');
include_once(__DIR__ . '/core/maxProperties.php');
include_once(__DIR__ . '/core/minContains.php');
include_once(__DIR__ . '/core/minimum.php');
include_once(__DIR__ . '/core/minItems.php');
include_once(__DIR__ . '/core/minLength.php');
include_once(__DIR__ . '/core/minProperties.php');
include_once(__DIR__ . '/core/multipleOf.php');
include_once(__DIR__ . '/core/not.php');
include_once(__DIR__ . '/core/oneOf.php');
include_once(__DIR__ . '/core/optional/bignum.php');
include_once(__DIR__ . '/core/optional/ecmascriptRegex.php');
include_once(__DIR__ . '/core/optional/floatOverflow.php');
include_once(__DIR__ . '/core/optional/format/color.php');
include_once(__DIR__ . '/core/optional/format/date.php');
include_once(__DIR__ . '/core/optional/format/dateTime.php');
include_once(__DIR__ . '/core/optional/format/duration.php');
include_once(__DIR__ . '/core/optional/format/email.php');
include_once(__DIR__ . '/core/optional/format/hostname.php');
include_once(__DIR__ . '/core/optional/format/hostName.php');
include_once(__DIR__ . '/core/optional/format/idnEmail.php');
include_once(__DIR__ . '/core/optional/format/idnHostname.php');
include_once(__DIR__ . '/core/optional/format/ipAddress.php');
include_once(__DIR__ . '/core/optional/format/ipv4.php');
include_once(__DIR__ . '/core/optional/format/ipv6.php');
include_once(__DIR__ . '/core/optional/format/iri.php');
include_once(__DIR__ . '/core/optional/format/iriReference.php');
include_once(__DIR__ . '/core/optional/format/jsonPointer.php');
include_once(__DIR__ . '/core/optional/format/regex.php');
include_once(__DIR__ . '/core/optional/format/relativeJsonPointer.php');
include_once(__DIR__ . '/core/optional/format/time.php');
include_once(__DIR__ . '/core/optional/format/unknown.php');
include_once(__DIR__ . '/core/optional/format/uri.php');
include_once(__DIR__ . '/core/optional/format/uriReference.php');
include_once(__DIR__ . '/core/optional/format/uriTemplate.php');
include_once(__DIR__ . '/core/optional/format/uuid.php');
include_once(__DIR__ . '/core/optional/nonBmpRegex.php');
include_once(__DIR__ . '/core/optional/refOfUnknownKeyword.php');
include_once(__DIR__ . '/core/pattern.php');
include_once(__DIR__ . '/core/patternProperties.php');
include_once(__DIR__ . '/core/prefixItems.php');
include_once(__DIR__ . '/core/properties.php');
include_once(__DIR__ . '/core/propertyDependencies.php');
include_once(__DIR__ . '/core/propertyNames.php');
include_once(__DIR__ . '/core/ref.php');
include_once(__DIR__ . '/core/required.php');
include_once(__DIR__ . '/core/type.php');
include_once(__DIR__ . '/core/unevaluatedItems.php');
include_once(__DIR__ . '/core/uniqueItems.php');

function schema_function_valid($item, $options) {
    $func = 'schema_valid_'.strtolower(preg_replace('/\$/', '', preg_replace('/([a-z])([A-Z])/', '$1_$2', $item)));
    $func = str_replace("-","_",$func);
    $func = (isset($options['func']) && isset($options['func'][$func]))?$options['func'][$func]:$func;
    return $func;
}

function schema_valid($schema, $data, $options) {
    if (!isset($options["schema"])) {
        $options["schema"] = $schema;
        $schema = compute_ref_schema($schema);
    }
    if (is_bool($schema)) return $schema;
    $keys = array_keys((array)$schema);
    $keys = in_array('$ref', $keys)?['$ref']:$keys;
    return array_reduce(
        $keys,
        function($result, $item) use ($schema, $data, $options) {
            $func = schema_function_valid($item, $options);
            return $result
                && (function_exists($func)
                    ?call_user_func($func, $schema, $data, $options)
                    :true);
        },
        true
    );
}

function json_schema($schema, $data, $version = 'draft-next') {
    $options = [];
    switch($version) {
        case "draft3":
            $options['func'] = [
                'schema_valid_format_time' => 'schema_valid_format_time_with_simple_time'
            ];
            break;
        case "draft-next":
            $options['func'] = [
                'schema_valid_contains' => 'schema_valid_contains_with_object'
            ];
            break;
    }
    return schema_valid($schema, $data, $options);
}
