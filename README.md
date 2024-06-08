# PHP Http Request
This PHP library provides a powerful and flexible way to send HTTP requests to any URL from within your Laravel applications.

### How to install

```php
composer require persgeek/http
```

### How to send request

#### Translator

```php
$fields = ['password' => 'admin'];

$translator = new Translator($fields);
```

#### Convertor

```php
$algos = ['password' => 'md5'];

$convertor = new Convertor($algos);
```

### Request

```php
$request = new Request();

$request->setTranslator($translator)
    ->setConvertor($convertor);

$request->setAddress('https://test.com/login')
    ->setMethod('POST');

$headers = [
    'Accept' => 'application/json'
];

$params = ['password' => '@password'];

$request->setHeaders($headers)
    ->setParams($params);

$response = $request->getResponse();

print_r($response);
```

### How to get response status

```php
$status = $response->getStatus();
```

### How to get response data
```php
$token = $response->getValue('token');
```