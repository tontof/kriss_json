KrISS json
==========

A simple and smart (or stupid) json schema validator

This project was an hobby when exploring the functional programming in PHP. It is not intendnded to be used in the real world, but for now (2023-05), it valids old drafts to draft7.

```bash
php schema/test.php
```

```
tests suite:	nb tests	nb files
draft3: 	  520/520	    35/35
draft4: 	  735/735	    38/38
draft6: 	  995/995	    48/48
draft7: 	1286/1286	    57/57
draft2019-09: 	1571/1651	    59/68
draft2020-12: 	1579/1677	    58/68
draft-next: 	1623/1724	    58/68
```

To validate a schema, include ```schema/json.php``` and call ```json_schema``` function.
```php
<?php

include_once(__DIR__ . '/schema/json.php');

$json = 'https://json-schema.org/learn/examples/address.schema.json';
$address = file_get_contents($json);

$data = '
{
  "locality":"locality",
  "region":"region"
}
';
var_dump(json_schema(json_decode($address), json_decode($data)));

$data = '
{
  "locality":"locality",
  "region":"region",
  "country-name":"country-name"
}
';
var_dump(json_schema(json_decode($address), json_decode($data)));

$data = '
{
  "locality":"locality",
  "region":"region",
  "country-name":"country-name",
  "post-office-box":"post-office-box"
}
';
var_dump(json_schema(json_decode($address), json_decode($data)));

$data = '
{
  "locality":"locality",
  "region":"region",
  "country-name":"country-name",
  "post-office-box":"post-office-box",
  "street-address":"street-address"
}
';
var_dump(json_schema(json_decode($address), json_decode($data)));
```

```php index.php``` will output:
```
bool(false)
bool(true)
bool(false)
bool(true)
```

I did not plan to update the code to valid more recent drafts, but don't hesitate to pull request!

Licence
=======
Copyleft (ɔ) - Tontof - https://tontof.net

Use KrISS json at your own risk.

[Free software means users have the four essential freedoms](http://www.gnu.org/philosophy/philosophy.html):
* to run the program
* to study and change the program in source code form
* to redistribute exact copies, and
* to distribute modified versions.
