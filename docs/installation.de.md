# Installation

## Voraussetzungen

- PHP 8.2 oder höher
- Sulu 3.0 oder höher
- Symfony 6.2 / 7.0 oder höher

## Migration vom SuluAdditionalAccountDataBundle

Dieses Bundle ersetzt das ehemalige `manuxi/sulu-additional-account-data-bundle`. Bei einem Upgrade vom alten Bundle bitte beachten:

- Das Composer-Paket wurde umbenannt von `manuxi/sulu-additional-account-data-bundle` zu `manuxi/sulu-extended-account-bundle`
- Der PHP-Namespace hat sich geändert von `Manuxi\SuluAdditionalAccountDataBundle` zu `Manuxi\SuluExtendedAccountBundle`
- Die API-Route hat sich geändert von `/admin/api/additional-account-data` zu `/admin/api/extended-account`
- Die 12 einzelnen String-Felder für Öffnungszeiten (`monAm`, `monPm`, etc.) wurden durch 3 JSON-Felder ersetzt (`businessHours`, `publicHolidays`, `holidayDates`)

Das alte Bundle vor der Installation entfernen:

```bash
composer remove manuxi/sulu-additional-account-data-bundle
composer require manuxi/sulu-extended-account-bundle
```

## Schritt 1: Paket installieren

```bash
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

```bash
php bin/console doctrine:schema:update --dump-sql
```

Änderungen anwenden:

```bash
php bin/console doctrine:schema:update --force
```

> **Wichtig:** Es sollten nur die Schema-Änderungen dieses Bundles verarbeitet werden.

## Schritt 5: Admin-Assets einrichten

Der Öffnungszeiten-Tab verwendet Content Types (`business_hours`, `public_holidays`, `holiday_dates`) aus dem [SuluAdminExtrasBundle](https://github.com/manuxi/SuluAdminExtrasBundle). Die JavaScript-Komponenten müssen in den Admin-Assets des Projekts registriert werden, damit sie korrekt dargestellt werden.

### A) `assets/admin/package.json` aktualisieren

Die Datei `assets/admin/package.json` im Projekt-Root öffnen. Die Abhängigkeit für das AdminExtrasBundle hinzufügen:

```json
{
    "dependencies": {
        "sulu-admin-extras-bundle": "file:../../vendor/manuxi/sulu-admin-extras-bundle/src/Resources"
    }
}
```

> Falls bereits andere Bundle-Abhängigkeiten eingetragen sind, einfach die `sulu-admin-extras-bundle`-Zeile daneben ergänzen.

### B) `assets/admin/app.js` aktualisieren

Die Datei `assets/admin/app.js` öffnen und das Bundle importieren:

```javascript
import 'sulu-admin-extras-bundle';
```

### C) Installieren & Bauen

Folgende Befehle ausführen, um die Abhängigkeiten zu installieren und die Admin-Assets zu kompilieren:

```bash
cd assets/admin
npm install
npm run build
```
