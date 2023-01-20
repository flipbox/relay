# Changelog
All Notable changes to `flipboxdigital/relay` will be documented in this file

## 4.0.0 - 2023-01-20
### Changed
- Updated dependencies: `zendframework/zend-diactoros` to `laminas/laminas-diactoros`

## 3.0.0 - 2018-03-06

### Changed
- updating Skeleton dependency
- new Runner which will auto resolve a Request/Response when invoked
- new RelayBuilder and RelayBuilderInterface to facilitate distributed composition of a relay

### Removed
- The concept of 'segment' as it serves the purpose of a middleware 'builder'.
- RelayHelper class as the logic now resides within the RelayBuilder

## 2.2.0 - 2017-01-05
### Removed
- Middleware configurable response success codes as they are overreaching

## 2.1.0 - 2017-12-19
### Changed
- Middleware supports configurable response success codes
- AbstractSegment::run now supports passing an existing request/response to it.

### Removed
- AbstractSegment::run cannot re-configure the segment
- AbstractSegment::__invoke cannot re-configure the segment

## 2.0.1 - 2017-06-13
### Added
- addBefore and addAfter interface methods

## 2.0.0 - 2017-05-30
### Added
- Initial release!