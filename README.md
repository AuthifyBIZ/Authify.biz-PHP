# Authify Php Example


This is the official Php Example for [Authify](https://authify.biz).
For more information, please visit [Documenatation](https://authify.biz/documentation).



### Init API
---
```php
require 'authify.php';

$auth_instance = new authify\api("VERSION", "PROGRAM KEY", "API / ENC KEY");
```

### Login User
---
```php
require 'authify.php';

$auth_instance = new authify\api("VERSION", "PROGRAM KEY", "API / ENC KEY");

if (isset($_POST_['submit'])) {
    $logged_in = $auth_instance->login($_GET['username'], $_GET['password']);

    if ($logged_in) {
        print_r($_SESSION["user_data"]);

        exit;
    }
}
```

### Register User
---
```php
require 'authify.php';

$auth_instance = new authify\api("VERSION", "PROGRAM KEY", "API / ENC KEY");

if (isset($_POST_['submit'])) {
    $logged_in = $auth_instance->register($_GET['username'], $_GET['email'], $_GET['password'], $_GET['token']);

    if ($logged_in) {
        print_r($_SESSION["user_data"]);

        exit;
    }
}
```

### Activate
---
```php	
require 'authify.php';

$auth_instance = new authify\api("VERSION", "PROGRAM KEY", "API / ENC KEY");

if (isset($_POST['submit'])) {
    $logged_in = $auth_instance->activate($_GET['username'],  $_GET['token']);

    if ($logged_in) {
        print_r($_SESSION["user_data"]);

        exit;
    }
}
```

### All in one
---
```php
require 'authify.php';

$auth_instance = new authify\api("VERSION", "PROGRAM KEY", "API / ENC KEY");

if(isset($_POST['submit'])){
	$logged_in = $auth_instance->all_in_one($_GET['token']);

	if($logged_in){
		print_r($_SESSION["user_data"]);

   		exit;
	}
}
```

### Log 
---
```php
require 'authify.php';

$auth_instance = new authify\api("VERSION", "PROGRAM KEY", "API / ENC KEY");

if(isset($_POST['submit'])){
	$logged_in = $auth_instance->log($_GET['username'], $_GET['message']);

	if($logged_in){
		print_r($_SESSION["user_data"]);

   		exit;
	}
}
```

