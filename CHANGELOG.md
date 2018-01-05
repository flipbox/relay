# Changelog
All Notable changes to `flipboxdigital/relay` will be documented in this file

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