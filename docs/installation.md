# Installation

## Requirements

- PHP 8.2 or higher
- Sulu 3.0 or higher
- Symfony 6.2 / 7.0 or higher

## Step 1: Install the package

```console
composer require manuxi/sulu-extended-account-bundle
```

## Step 2: Register the bundle

If you are **not** using Symfony Flex, add the bundle manually in your `config/bundles.php`:

```php
return [
    //...
    Manuxi\SuluExtendedAccountBundle\SuluExtendedAccountBundle::class => ['all' => true],
];
```

## Step 3: Configure routing

Add the following to your `config/routes/routes_admin.yaml`:

```yaml
SuluExtendedAccountBundle:
    resource: '@SuluExtendedAccountBundle/Resources/config/routes_admin.yaml'
```

## Step 4: Update database schema

The bundle extends the `co_accounts` table with additional columns. Preview the required SQL changes with:

```console
php bin/console doctrine:schema:update --dump-sql
```

Apply the changes with:

```console
php bin/console doctrine:schema:update --force
```

> **Important:** Make sure you only process the schema updates related to this bundle.
