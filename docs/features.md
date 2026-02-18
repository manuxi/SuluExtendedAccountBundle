# Features

## Overview

The SuluExtendedAccountBundle adds two tabs to the Sulu account edit form:

1. **Company Data** — Register number, jurisdiction, descriptor and claim
2. **Opening Hours** — Business hours, public holidays and company holidays

The opening hours use the content types from the **SuluAdminExtrasBundle** (`business_hours`, `public_holidays`, `holiday_dates`).

## Extended Account Fields

### Company Data Tab

| Field | Type | Description |
|-------|------|-------------|
| `registerNumber` | string (255) | Commercial register number |
| `placeOfJurisdiction` | string (255) | Registry court / place of jurisdiction |
| `descriptor` | string (255) | Company descriptor |
| `claim` | string (255) | Company claim / slogan |

### Opening Hours Tab

| Field | Type | Description |
|-------|------|-------------|
| `businessHours` | JSON | Weekly schedule with time slots and breaks |
| `publicHolidays` | JSON | Public holidays via Nager.Date API |
| `holidayDates` | JSON | Company holidays / closure periods |

All fields are optional (nullable).

## Admin Integration

The bundle registers two form tabs in the Sulu admin account edit view after the default "Details" tab.

### API Endpoints

| Method | Path | Description |
|--------|------|-------------|
| `GET` | `/admin/api/extended-account/{id}` | Retrieve extended account data |
| `PUT` | `/admin/api/extended-account/{id}` | Update extended account data |

Both endpoints are secured with the standard Sulu account security context.

## Twig Functions

The bundle provides four Twig functions for frontend use:

### `is_open_now(accountId)`

Returns `true` if the account is currently open (considering business hours, public holidays and company holidays).

```twig
{% if is_open_now(account.id) %}
    <span class="badge badge-success">Open now</span>
{% else %}
    <span class="badge badge-danger">Closed</span>
{% endif %}
```

### `get_business_hours(accountId)`

Returns the full weekly business hours schedule as an array.

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

Returns the business hours configuration for today (or `null` if not configured).

```twig
{% set today = get_today_hours(account.id) %}
{% if today and today.enabled %}
    Today: {% for slot in today.slots %}{{ slot.start }}–{{ slot.end }} {% endfor %}
{% else %}
    Closed today
{% endif %}
```

### `is_holiday(accountId)`

Returns `true` if today is a public holiday or falls within a company holiday period.

```twig
{% if is_holiday(account.id) %}
    <p>We are closed today due to a holiday.</p>
{% endif %}
```

## Entity

The bundle provides a custom `Account` entity (`Manuxi\SuluExtendedAccountBundle\Entity\Account`) that extends `Sulu\Bundle\ContactBundle\Entity\Account`. It is mapped to the existing `co_accounts` table.

## Dependencies

This bundle requires the **SuluAdminExtrasBundle** (`manuxi/sulu-admin-extras-bundle`) for the `business_hours`, `public_holidays` and `holiday_dates` content types.