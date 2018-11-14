MegaMaker Twitter List Sync
======

This little app fetches all twitter accounts from the MegaMaker club into a Twitter List


Installation
------

1. Install all requirements with composers


```
composer install
```


2. Setup the Twitter stuff

create a etc/settings.php file

```php
<?php

return [
    'oauth_access_token'        => "YOUR_OAUTH_ACCESS_TOKEN",
    'oauth_access_token_secret' => "YOUR_OAUTH_ACCESS_TOKEN_SECRET",
    'consumer_key'              => "YOUR_CONSUMER_KEY",
    'consumer_secret'           => "YOUR_CONSUMER_SECRET",

    'twitter_user' => 'de_henne',
    'twitter_list' => 'megamaker'
];

```
