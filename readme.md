# Microcli

Simple extension for text output for php on command line.

#### Install vía [Composer](https://packagist.org/packages/oscarweb/microcli "Composer")
Just add this line to your `composer.json` file:
```json
"oscarweb/microcli": "0.1.0"
```
or run

```sh
composer require oscarweb/microcli
```
#### Example Write
Create a new file: `"example.php"`
```php
#!/usr/bin/php;
<?php
if(php_sapi_name() !== 'cli'){
	exit();
}
//- enter correct path
require 'vendor/autoload.php';

use Microcli\Microcli;

$app = new Microcli();

$app->color('success')->write('Lorem Ipsum...');
```
From your terminal run the file: `php example.php`

![Example Write](https://raw.githubusercontent.com/oscarweb/microcli/main/examples/images/readme_write.png "Example Write")
#### Example Command

Create a new file: `"command"`
```php
#!/usr/bin/php;
<?php
if(php_sapi_name() !== 'cli'){
	exit();
}
//- enter correct path
require 'vendor/autoload.php';

use Microcli\Microcli;

$app = new Microcli();

$app->addCommand('hello', function($argv) use ($app){
	$app->line();
	$app->color('danger')->write('Hello World');
	$app->line();
	$app->exit();
});

$app->run($argv);
```
From your terminal run the file: `php command hello`

![Example Command](https://raw.githubusercontent.com/oscarweb/microcli/main/examples/images/readme_command.png "Example Command")

You can see more examples [here](https://github.com/oscarweb/microcli/tree/main/examples "More Examples").