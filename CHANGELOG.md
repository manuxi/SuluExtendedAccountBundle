# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [3.0.0] - 2026-02-18

### Changed
- Renamed bundle from `SuluAdditionalAccountDataBundle` to `SuluExtendedAccountBundle`
- Renamed composer package from `manuxi/sulu-additional-account-data-bundle` to `manuxi/sulu-extended-account-bundle`
- Renamed PHP namespace from `Manuxi\SuluAdditionalAccountDataBundle` to `Manuxi\SuluExtendedAccountBundle`
- Renamed admin class from `AdditionalAccountDataAdmin` to `ExtendedAccountAdmin`
- Renamed controller class from `AdditionalAccountDataController` to `ExtendedAccountController`
- Renamed DI extension class from `SuluAdditionalAccountDataExtension` to `SuluExtendedAccountExtension`
- Renamed DI configuration key from `additional-account-data` to `extended-account`
- Changed API route path from `/admin/api/additional-account-data` to `/admin/api/extended-account`
- Changed route names from `sulu_additional_account_data.*` to `sulu_extended_account.*`
- Changed resource key from `additional_account_data` to `extended_account`
- Changed form key from `additional_account_data` to `extended_account`
- Changed all translation keys from `additional_account_data.*` to `extended_account.*`
- Renamed form configuration file from `additional_account_data.xml` to `extended_account.xml`

### Added
- Documentation in `docs/` (English and German)
- German README (`README.de.md`)
- This changelog file
