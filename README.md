# goooto-php-client
PHP client for [Gooo.to](https://gooo.to) API


```
composer require kodventure/goooto-php-client
```

# example

```php
<?php

use Kodventure\GoooTo\Client;

require __DIR__ . '/vendor/autoload.php';


$client = new Client("GOOO.TO API KEY","GOOO.TO API SECRET");
$data = $client->shorten("https://github.com/Kodventure/goooto-php-client");

print_r($data);

/* output 
stdClass Object
(
    [data] => stdClass Object
        (
            [target] => https://github.com/Kodventure/goooto-php-client
            [user_id] => 1
            [domain] => gooo.to
            [title] => https://github.com/Kodventure/goooto-php-client
            [path] => 7GUsvz
            [updated_at] => 2020-11-27T14:51:04.000000Z
            [created_at] => 2020-11-27T14:51:04.000000Z
            [id] => 148
            [link] => https://gooo.to/7GUsvz
            [is_social] => 0
            [social] => 
        )
)
*/
```
