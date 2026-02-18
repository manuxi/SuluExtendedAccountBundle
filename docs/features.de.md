# Funktionen

## Übersicht

Das SuluExtendedAccountBundle fügt dem Sulu-Account-Bearbeitungsformular zwei Tabs hinzu:

1. **Firmendaten** — Handelsregisternummer, Registergericht, Descriptor und Slogan
2. **Öffnungszeiten** — Geschäftszeiten, gesetzliche Feiertage und Betriebsferien

Die Öffnungszeiten verwenden die Content Types aus dem **SuluAdminExtrasBundle** (`business_hours`, `public_holidays`, `holiday_dates`).

## Erweiterte Account-Felder

### Tab Firmendaten

| Feld | Typ | Beschreibung |
|------|-----|--------------|
| `registerNumber` | string (255) | Handelsregisternummer |
| `placeOfJurisdiction` | string (255) | Registergericht |
| `descriptor` | string (255) | Firmenbeschreibung |
| `claim` | string (255) | Firmenslogan |

### Tab Öffnungszeiten

| Feld | Typ | Beschreibung |
|------|-----|--------------|
| `businessHours` | JSON | Wochenplan mit Zeitslots und Pausen |
| `publicHolidays` | JSON | Gesetzliche Feiertage via Nager.Date API |
| `holidayDates` | JSON | Betriebsferien / Schließzeiten |

Alle Felder sind optional (nullable).

## Admin-Integration

Das Bundle registriert zwei Formular-Tabs in der Sulu-Admin-Account-Bearbeitungsansicht nach dem Standard-Tab "Details".

### API-Endpunkte

| Methode | Pfad | Beschreibung |
|---------|------|--------------|
| `GET` | `/admin/api/extended-account/{id}` | Erweiterte Account-Daten abrufen |
| `PUT` | `/admin/api/extended-account/{id}` | Erweiterte Account-Daten aktualisieren |

Beide Endpunkte sind mit dem Standard-Sulu-Account-Sicherheitskontext abgesichert.

## Twig-Funktionen

Das Bundle stellt vier Twig-Funktionen für die Frontend-Ausgabe bereit:

### `is_open_now(accountId)`

Gibt `true` zurück, wenn der Account aktuell geöffnet ist (unter Berücksichtigung von Geschäftszeiten, Feiertagen und Betriebsferien).

```twig
{% if is_open_now(account.id) %}
    <span class="badge badge-success">Jetzt geöffnet</span>
{% else %}
    <span class="badge badge-danger">Geschlossen</span>
{% endif %}
```

### `get_business_hours(accountId)`

Gibt den vollständigen Wochenplan als Array zurück.

```twig
{% set hours = get_business_hours(account.id) %}
{% for day, config in hours %}
    {% if config.enabled %}
        <strong>{{ day }}:</strong>
        {% for slot in config.slots %}
            {{ slot.start }} – {{ slot.end }}
        {% endfor %}
    {% endif %}
{% endfor %}
```

### `get_today_hours(accountId)`

Gibt die Öffnungszeiten für heute zurück (oder `null` wenn nicht konfiguriert).

```twig
{% set today = get_today_hours(account.id) %}
{% if today and today.enabled %}
    Heute: {% for slot in today.slots %}{{ slot.start }}–{{ slot.end }} {% endfor %}
{% else %}
    Heute geschlossen
{% endif %}
```

### `is_holiday(accountId)`

Gibt `true` zurück, wenn heute ein gesetzlicher Feiertag ist oder in einen Betriebsferien-Zeitraum fällt.

```twig
{% if is_holiday(account.id) %}
    <p>Wir haben heute aufgrund eines Feiertags geschlossen.</p>
{% endif %}
```

## Entität

Das Bundle stellt eine eigene `Account`-Entität (`Manuxi\SuluExtendedAccountBundle\Entity\Account`) bereit, die `Sulu\Bundle\ContactBundle\Entity\Account` erweitert. Sie ist auf die bestehende Tabelle `co_accounts` gemappt.

## Abhängigkeiten

Dieses Bundle benötigt das **SuluAdminExtrasBundle** (`manuxi/sulu-admin-extras-bundle`) für die Content Types `business_hours`, `public_holidays` und `holiday_dates`.