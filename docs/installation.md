# Installation

## Prerequisites

- PHP 8.2 or higher
- Sulu 3.0 or higher
- Symfony 6.2 / 7.0 or higher

## Migration from SuluAdditionalAccountDataBundle

This bundle replaces the former `manuxi/sulu-additional-account-data-bundle`. If you are upgrading from the old bundle, please note:

- The composer package has been renamed from `manuxi/sulu-additional-account-data-bundle` to `manuxi/sulu-extended-account-bundle`
- The PHP namespace has changed from `Manuxi\SuluAdditionalAccountDataBundle` to `Manuxi\SuluExtendedAccountBundle`
- The API route has changed from `/admin/api/additional-account-data` to `/admin/api/extended-account`
- The 12 individual string fields for opening hours (`monAm`, `monPm`, etc.) have been replaced with 3 JSON fields (`businessHours`, `publicHolidays`, `holidayDates`)

Remove the old bundle before installing:

```bash
composer remove manuxi/sulu-additional-account-data-bundle
composer require manuxi/sulu-extended-account-bundle
```

## Step 1: Install the package

```bash
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

```bash
php bin/console doctrine:schema:update --dump-sql
```

Apply the changes with:

```bash
php bin/console doctrine:schema:update --force
```

> **Important:** Make sure you only process the schema updates related to this bundle.

## Step 5: Admin assets setup

The opening hours tab uses content types (`business_hours`, `public_holidays`, `holiday_dates`) from the [SuluAdminExtrasBundle](https://github.com/manuxi/SuluAdminExtrasBundle). Their JavaScript components must be registered in your project's admin assets to render properly.

### A) Update `assets/admin/package.json`

Open the file `assets/admin/package.json` in your project root. Add the dependency for the AdminExtrasBundle:

```json
{
    "dependencies": {
        "sulu-admin-extras-bundle": "file:../../vendor/manuxi/sulu-admin-extras-bundle/src/Resources"
    }
}
```

> If you already have other bundle dependencies listed, simply add the `sulu-admin-extras-bundle` line alongside them.

### B) Update `assets/admin/app.js`

Open `assets/admin/app.js` and import the bundle:

```javascript
import 'sulu-admin-extras-bundle';
```

### C) Install & Build

Run the following commands to install dependencies and compile the admin assets:

```bash
cd assets/admin
npm install
npm run build
```
