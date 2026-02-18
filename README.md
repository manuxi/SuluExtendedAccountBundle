# SuluExtendedAccountBundle
[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://github.com/manuxi/SuluExtendedAccountBundle/LICENSE)
![GitHub Tag](https://img.shields.io/github/v/tag/manuxi/SuluExtendedAccountBundle)
![Supports Sulu 2.6 or later](https://img.shields.io/badge/%20Sulu->=3.0-0088cc?color=00b2df)

A Sulu bundle to extend the account entity with additional properties such as company data, descriptor/claim, and opening hours.

## Documentation

- [Installation](docs/installation.md)
- [Features](docs/features.md)

## Quick Start

```console
composer require manuxi/sulu-extended-account-bundle
```

If you are **not** using Symfony Flex, register the bundle in `config/bundles.php`:

```php
return [
    //...
    Manuxi\SuluExtendedAccountBundle\SuluExtendedAccountBundle::class => ['all' => true],
];
```

Add the admin routes to `config/routes/routes_admin.yaml`:

```yaml
SuluExtendedAccountBundle:
    resource: '@SuluExtendedAccountBundle/Resources/config/routes_admin.yaml'
```

Update the database schema:

```console
php bin/console doctrine:schema:update --force
```

For detailed instructions see the [Installation Guide](docs/installation.md).

## Configuration

There is no configuration required at this time.

## Contributing

Please feel comfortable submitting issues or pull requests. Feedback to improve the bundle is always welcome.

## License

This bundle is released under the [MIT License](LICENSE).
