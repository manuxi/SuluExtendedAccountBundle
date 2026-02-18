# Features

## Overview

The SuluExtendedAccountBundle adds a new tab to the Sulu account edit form, providing additional fields for managing extended account data.

## Extended Account Fields

The bundle adds the following fields to the account entity:

### Company Data

| Field | Type | Description |
|-------|------|-------------|
| `registerNumber` | string (255) | Commercial register number |
| `placeOfJurisdiction` | string (255) | Registry court / place of jurisdiction |

### Descriptor / Claim

| Field | Type | Description |
|-------|------|-------------|
| `descriptor` | string (255) | Company descriptor |
| `claim` | string (255) | Company claim / slogan |

### Opening Hours

| Field | Type | Description |
|-------|------|-------------|
| `monAm` / `monPm` | string (255) | Monday morning / afternoon |
| `tueAm` / `tuePm` | string (255) | Tuesday morning / afternoon |
| `wedAm` / `wedPm` | string (255) | Wednesday morning / afternoon |
| `thurAm` / `thurPm` | string (255) | Thursday morning / afternoon |
| `friAm` / `friPm` | string (255) | Friday morning / afternoon |
| `satAm` / `satPm` | string (255) | Saturday morning / afternoon |

All fields are optional (nullable).

## Admin Integration

The bundle registers a new form tab in the Sulu admin account edit view. The tab appears after the default "Details" tab and provides a save toolbar action.

### API Endpoints

| Method | Path | Description |
|--------|------|-------------|
| `GET` | `/admin/api/extended-account/{id}` | Retrieve extended account data |
| `PUT` | `/admin/api/extended-account/{id}` | Update extended account data |

Both endpoints are secured with the standard Sulu account security context.

## Entity

The bundle provides a custom `Account` entity (`Manuxi\SuluExtendedAccountBundle\Entity\Account`) that extends `Sulu\Bundle\ContactBundle\Entity\Account`. It is mapped to the existing `co_accounts` table and adds the additional columns listed above.

## Testing

The bundle includes a full unit test suite using PHPUnit 11. Run the tests with:

```console
vendor/bin/phpunit
```
