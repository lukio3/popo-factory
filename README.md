# Making it easy to mock your POPO's

[![Latest Version on Packagist](https://img.shields.io/packagist/v/morrislaptop/popo-factory.svg?style=flat-square)](https://packagist.org/packages/morrislaptop/popo-factory)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/morrislaptop/popo-factory/Tests?label=tests)](https://github.com/morrislaptop/popo-factory/actions?query=workflow%3ATests+branch%3Amaster)
[![Total Downloads](https://img.shields.io/packagist/dt/morrislaptop/popo-factory.svg?style=flat-square)](https://packagist.org/packages/morrislaptop/popo-factory)

This package supports mocking POPO. This is a fork of [Data Transfer Object Factory](https://github.com/anteris-dev/data-transfer-object-factory) which supports normal 
PHP Objects instead of DTO's.

## Installation

You can install the package via composer:

```bash
composer require morrislaptop/popo-factory
```

## Usage

If you are simply using PHP default types in your DTOs, you can get started right away. Just pass your DTO FQDN to the static dto method. Calling this method on the factory returns an instance of `Morrislaptop\PopoFactory\PopoFactory` which provides the following methods.

- `count()` - _Allows you to specify how many DTOs to be generated. By default they will be returned in an array unless a collection is specified._
- `make()` - _Called when you are ready to generate the DTO. Returns the generated DTO._
- `random()` - _Generates a random number of DTOs_
- `sequence()` - _Alternates a specific state. (See below)_
- `state()` - _Manually sets properties based on the array of values passed._

Examples of these methods can be found below.

```php

use Morrislaptop\PopoFactory\Factory;

// Creates one DTO
Factory::dto(PersonData::class)->make();

// Creates two DTOs in an array
Factory::dto(PersonData::class)->count(2)->make();

// Sets the first name of every person to "Jim"
Factory::dto(PersonData::class)
    ->random()
    ->state([
        'firstName' => 'Jim',
    ])
    ->make();

// Alternates the names of each person between "Jim" and "Susie"
Factory::dto(PersonData::class)
    ->random()
    ->sequence(
        [ 'firstName' => 'Jim' ],
        [ 'firstName' => 'Susie' ]
    )
    ->make();

```

## Extending

It used to be that you had to extend the factory class to utilize custom types. You can now do so through the static `registerProvider()` method on the `PropertyFactory` class. This method takes two arguments. The first should be the FQDN of the class you are providing (e.g. `Carbon\Carbon`) OR the built-in type (e.g. `string`). The second should be a callback that returns the generated value. This callback is passed two properties when called to assist in generating the value. The first is an instance of `Anteris\FakerMap\FakerMap` which can be used to help generate fake data. The second is an instance of `ReflectionProperty` which contains information about the property being generated.

For example, to support Carbon:

```php

use Morrislaptop\PopoFactory\PropertyFactory;

use Anteris\FakerMap\FakerMap;

PropertyFactory::registerProvider('Carbon\Carbon', fn(FakerMap $fakerMap) => Carbon::parse(
    $fakerMap->closest('dateTime')->fake()
));

```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Craig Morris](https://github.com/morrislaptop)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
