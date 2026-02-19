# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [1.0.0] - 2026-02-19

### Changed
- Replaced 12 individual opening hours string fields (`monAm`, `monPm`, ...) with 3 JSON fields (`businessHours`, `publicHolidays`, `holidayDates`)
- Opening hours now use `business_hours`, `public_holidays` and `holiday_dates` content types from SuluAdminExtrasBundle
- Split admin form into two tabs: "Company Data" and "Opening Hours"
- Controller now uses `array_key_exists` checks for partial updates (both tabs share one API endpoint)

### Added
- Twig extension with 4 functions: `is_open_now()`, `get_business_hours()`, `get_today_hours()`, `is_holiday()`
- Hard dependency on `manuxi/sulu-admin-extras-bundle` (^3.0)
- New form `extended_account_openings.xml` for the opening hours tab
- Unit tests for Twig extension

### Removed
- 12 individual string columns for opening hours (`monAm`, `monPm`, `tueAm`, `tuePm`, `wedAm`, `wedPm`, `thurAm`, `thurPm`, `friAm`, `friPm`, `satAm`, `satPm`)
- All `openings.*` translation keys (replaced by AdminExtrasBundle translations)

## 2026-02-18

### Changed
- Renamed bundle from `SuluAdditionalAccountDataBundle` to `SuluExtendedAccountBundle`
- Renamed composer package from `manuxi/sulu-additional-account-data-bundle` to `manuxi/sulu-extended-account-bundle`
- Renamed PHP namespace from `Manuxi\SuluAdditionalAccountDataBundle` to `Manuxi\SuluExtendedAccountBundle`
- Renamed admin class from `AdditionalAccountDataAdmin` to `ExtendedAccountAdmin`
- Renamed controller class from `AdditionalAccountDataController` to `ExtendedAccountController`
- Renamed DI extension class from `SuluAdditionalAccountDataExtension` to `SuluExtendedAccountExtension`
- Changed API route path from `/admin/api/additional-account-data` to `/admin/api/extended-account`
- Changed route names, resource key, form key and translation keys accordingly

### Added
- Unit tests for all classes
- PHPUnit 11 configuration
- Documentation in `docs/` (English and German)
- German README

### Fixed
- Initialized all nullable entity properties with `= null` default

### Upgraded
- Upgraded `phpunit/phpunit` from `^8.0` to `^11.0`
- Dropped Sulu 2.x support, now requires `sulu/sulu: ^3.0`