# SuluExtendedAccountBundle

[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://github.com/manuxi/SuluExtendedAccountBundle/LICENSE)
![GitHub Tag](https://img.shields.io/github/v/tag/manuxi/SuluExtendedAccountBundle)
![Supports Sulu 3.0 or later](https://img.shields.io/badge/Sulu->=3.0-0088cc?color=00b2df)

A Sulu bundle to extend the account entity with company data, business hours, public holidays and company holidays.

**English** | [🇩🇪 Deutsch](README.de.md)

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

## Dependencies

This bundle requires the [SuluAdminExtrasBundle](https://github.com/manuxi/SuluAdminExtrasBundle) for the `business_hours`, `public_holidays` and `holiday_dates` content types.

## Twig Functions

The bundle provides Twig functions for frontend use:

| Function | Returns | Description |
|----------|---------|-------------|
| `is_open_now(accountId)` | `bool` | Whether the account is currently open |
| `get_business_hours(accountId)` | `array` | Full weekly schedule |
| `get_today_hours(accountId)` | `array\|null` | Today's hours |
| `is_holiday(accountId)` | `bool` | Whether today is a holiday |

See [Features](docs/features.md) for usage examples.

## Configuration

There is no configuration required at this time.

## Contributing

Please feel comfortable submitting issues or pull requests. Feedback to improve the bundle is always welcome.

## License

This bundle is released under the [MIT License](LICENSE).