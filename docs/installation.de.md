# Installation

## Voraussetzungen

- PHP 8.2 oder h&ouml;her
- Sulu 3.0 oder h&ouml;her
- Symfony 6.2 / 7.0 oder h&ouml;her

## Schritt 1: Paket installieren

```console
composer require manuxi/sulu-extended-account-bundle
```

## Schritt 2: Bundle registrieren

Falls Symfony Flex **nicht** verwendet wird, muss das Bundle manuell in der `config/bundles.php` eingetragen werden:

```php
return [
    //...
    Manuxi\SuluExtendedAccountBundle\SuluExtendedAccountBundle::class => ['all' => true],
];
```

## Schritt 3: Routing konfigurieren

Folgendes in die `config/routes/routes_admin.yaml` eintragen:

```yaml
SuluExtendedAccountBundle:
    resource: '@SuluExtendedAccountBundle/Resources/config/routes_admin.yaml'
```

## Schritt 4: Datenbankschema aktualisieren

Das Bundle erweitert die Tabelle `co_accounts` um zusätzliche Spalten. Die benötigten SQL-Änderungen können vorab angezeigt werden:

```console
php bin/console doctrine:schema:update --dump-sql
```

Änderungen anwenden:

```console
php bin/console doctrine:schema:update --force
```

> **Wichtig:** Es sollten nur die Schema-Änderungen dieses Bundles verarbeitet werden.
