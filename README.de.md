# SuluExtendedAccountBundle

![php workflow](https://github.com/manuxi/SuluExtendedAccountBundle/actions/workflows/php.yml/badge.svg)
![symfony workflow](https://github.com/manuxi/SuluExtendedAccountBundle/actions/workflows/symfony.yml/badge.svg)
[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://github.com/manuxi/SuluExtendedAccountBundle/LICENSE)
![GitHub Tag](https://img.shields.io/github/v/tag/manuxi/SuluExtendedAccountBundle)
![Supports Sulu 3.0 or later](https://img.shields.io/badge/Sulu->=3.0-0088cc?color=00b2df)

[🇬🇧 English](README.md) | **Deutsch**

Ein Sulu-Bundle zur Erweiterung der Account-Entity um Firmendaten, Geschäftszeiten, gesetzliche Feiertage und Betriebsferien.

> **Hinweis:** Dieses Bundle ersetzt das ehemalige `manuxi/sulu-additional-account-data-bundle` (`SuluAdditionalAccountDataBundle`).

![Firmendaten](docs/img/additional_data.de.png)

![Öffnungszeiten](docs/img/openings.de.png)

## 📋 Voraussetzungen

- PHP 8.2 oder höher
- Sulu CMS 3.0 oder höher
- Symfony 6.2 / 7.0 oder höher
- [SuluAdminExtrasBundle](https://github.com/manuxi/SuluAdminExtrasBundle) (wird automatisch als Abhängigkeit installiert)

## 👩🏻‍🏭 Installation

### Schritt 1: Paket installieren

```bash
composer require manuxi/sulu-extended-account-bundle
```

Falls Symfony Flex **nicht** verwendet wird, muss das Bundle in der `config/bundles.php` registriert werden:

```php
return [
    //...
    Manuxi\SuluExtendedAccountBundle\SuluExtendedAccountBundle::class => ['all' => true],
];
```

### Schritt 2: Routing konfigurieren

Folgendes in die `config/routes/routes_admin.yaml` eintragen:

```yaml
SuluExtendedAccountBundle:
    resource: '@SuluExtendedAccountBundle/Resources/config/routes_admin.yaml'
```

### Schritt 3: Datenbankschema aktualisieren

```bash
# Vorschau der benötigten SQL-Änderungen
php bin/console doctrine:schema:update --dump-sql

# Änderungen anwenden
php bin/console doctrine:schema:update --force
```

> **Wichtig:** Es sollten nur die Schema-Änderungen dieses Bundles verarbeitet werden.

### Schritt 4: Admin-Assets einrichten

Die Öffnungszeiten-Features (Geschäftszeiten, Feiertage, Betriebsferien) verwenden Content Types aus dem **SuluAdminExtrasBundle**. Die JavaScript-Komponenten müssen in den Admin-Assets registriert werden.

**A) `assets/admin/package.json` aktualisieren**

Die Abhängigkeit für das AdminExtrasBundle hinzufügen:

```json
{
    "dependencies": {
        "sulu-admin-extras-bundle": "file:../../vendor/manuxi/sulu-admin-extras-bundle/src/Resources"
    }
}
```

**B) `assets/admin/app.js` aktualisieren**

Das Bundle importieren:

```javascript
import 'sulu-admin-extras-bundle';
```

**C) Installieren & Bauen**

```bash
cd assets/admin
npm install
npm run build
```

Detaillierte Anweisungen finden sich in der [Installationsanleitung](docs/installation.de.md).

## ✨ Features

### Firmendaten
- Handelsregisternummer, Registergericht, Firmenbeschreibung und Slogan

### Öffnungszeiten
- Wöchentlicher Geschäftszeiten-Plan mit Zeitslots und Pausen
- Gesetzliche Feiertage via Nager.Date API
- Betriebsferien / Schließzeiten

### Twig-Funktionen
Das Bundle stellt Twig-Funktionen für die Frontend-Ausgabe bereit:

| Funktion | Rückgabe | Beschreibung |
|----------|----------|--------------|
| `is_open_now(accountId)` | `bool` | Ob der Account gerade geöffnet ist |
| `get_business_hours(accountId)` | `array` | Vollständiger Wochenplan |
| `get_today_hours(accountId)` | `array\|null` | Heutige Öffnungszeiten |
| `is_holiday(accountId)` | `bool` | Ob heute ein Feiertag ist |

Siehe [Funktionen](docs/features.de.md) für Anwendungsbeispiele.

## 📖 Dokumentation

Detaillierte Dokumentation im [docs/](docs/) Verzeichnis:

- [Installation](docs/installation.de.md) - Vollständige Installationsanleitung
- [Funktionen](docs/features.de.md) - Feature-Übersicht und Twig-Beispiele

## 🧶 Konfiguration

Aktuell ist keine zusätzliche Konfiguration erforderlich.

## 👩‍🍳 Mitwirken

Issues und Pull Requests sind willkommen! Feedback zur Verbesserung des Bundles ist jederzeit erwünscht.

## 📝 Lizenz

Dieses Bundle wird unter der [MIT-Lizenz](LICENSE) veröffentlicht.

## 🎉 Credits

Erstellt und gewartet von [manuxi](https://github.com/manuxi).

Danke an das Sulu-Team für das tolle CMS und den fantastischen Support!
