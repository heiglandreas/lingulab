# Lingulab

is a german service provider for quality-measurements of copytexts.

They have an API that is based on SOAP.

This library tries to wrap that interface and allows you
to easily integrate the API into your PHP-based projects.

## Installation

This library is beast installed via composer:

```composer require org_heigl/lingulab```

## Usage

```php

$lingulab = new Lingulab(
    $your_lingulab_username,
    $your_lingulab_password
);


$quality = $lingulab->processText($text);
```
