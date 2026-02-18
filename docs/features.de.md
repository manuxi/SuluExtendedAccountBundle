# Funktionen

## Übersicht

Das SuluExtendedAccountBundle fügt dem Sulu-Account-Bearbeitungsformular einen neuen Tab hinzu, über den zusätzliche Felder für erweiterte Account-Daten verwaltet werden können.

## Erweiterte Account-Felder

Das Bundle fügt der Account-Entität folgende Felder hinzu:

### Firmendaten

| Feld | Typ | Beschreibung |
|------|-----|--------------|
| `registerNumber` | string (255) | Handelsregisternummer |
| `placeOfJurisdiction` | string (255) | Registergericht |

### Descriptor / Slogan

| Feld | Typ | Beschreibung |
|------|-----|--------------|
| `descriptor` | string (255) | Firmenbeschreibung |
| `claim` | string (255) | Firmenslogan |

### Öffnungszeiten

| Feld | Typ | Beschreibung |
|------|-----|--------------|
| `monAm` / `monPm` | string (255) | Montag vormittag / nachmittag |
| `tueAm` / `tuePm` | string (255) | Dienstag vormittag / nachmittag |
| `wedAm` / `wedPm` | string (255) | Mittwoch vormittag / nachmittag |
| `thurAm` / `thurPm` | string (255) | Donnerstag vormittag / nachmittag |
| `friAm` / `friPm` | string (255) | Freitag vormittag / nachmittag |
| `satAm` / `satPm` | string (255) | Samstag vormittag / nachmittag |

Alle Felder sind optional (nullable).

## Admin-Integration

Das Bundle registriert einen neuen Formular-Tab in der Sulu-Admin-Account-Bearbeitungsansicht. Der Tab erscheint nach dem Standard-Tab "Details" und bietet eine Speichern-Aktion in der Toolbar.

### API-Endpunkte

| Methode | Pfad | Beschreibung |
|---------|------|--------------|
| `GET` | `/admin/api/extended-account/{id}` | Erweiterte Account-Daten abrufen |
| `PUT` | `/admin/api/extended-account/{id}` | Erweiterte Account-Daten aktualisieren |

Beide Endpunkte sind mit dem Standard-Sulu-Account-Sicherheitskontext abgesichert.

## Entität

Das Bundle stellt eine eigene `Account`-Entität (`Manuxi\SuluExtendedAccountBundle\Entity\Account`) bereit, die `Sulu\Bundle\ContactBundle\Entity\Account` erweitert. Sie ist auf die bestehende Tabelle `co_accounts` gemappt und fügt die oben aufgelisteten Spalten hinzu.

## Tests

Das Bundle enthält eine vollständige Unit-Test-Suite mit PHPUnit 11. Tests ausführen:

```console
vendor/bin/phpunit
```
