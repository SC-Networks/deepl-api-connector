# Changelog
## [4.0.0] - 2025-02-06
### Added
- Add method to translate a batch of texts
- Check all Headers for json reponse
- Add several new languages
- Update Dependencies & Apply some variable descriptions
- Throw RequestExeption on client- or server errors #68
- Implement method to retrieve supported languages
- Issue #47 : Glossary implementation

### Changed
- Remove source_lang from file translation request if empty
- Move API key in request header and change body to json format (#89)
  
## [3.3.1] - 2024-11-26
### Fixed
- Remove some trailing commas to ensure php 7.4 compatibility 

## [3.3.0] - 2023-03-08
### Added
- Add method for batch translation of multiple texts #42

## [3.2.0] - 2023-01-04
### Added
- Add method for retrieving all supported languages by deepl

### Fixed
- Erroneous responses due to server- or client-errors now throw a `RequestException`

## [3.1.0] - 2022-09-20
### Added
- Add support for recently added languages (ukrainian, indonesian, turkish)

## [3.0.5] - 2022-06-07
### Fixed
- Correct deepl response header parsing for file submissions (the header has  been changed upstream)

## [3.0.4] - 2022-04-27
### Fixed
- Removed erroneous method call on ClientExceptionInterface instances in error
  case (psr-18 migration aftermath)

## [3.0.3] - 2022-03-01
### Changed
- File RequestHandler Method from get to post

## [3.0.2] - 2022-02-28
### Changed
- FileStatus RequestHandler Method from get to post

## [3.0.1] - 2022-02-25
### Added
- phpstan static analyses (dev)
### Fixed
- File- Upload Error (invalid file data)

## [3.0.0] - 2022-01-20
### Added
- Support Deepl Free Api (https://support.deepl.com/hc/en/articles/360021200939-DeepL-API-Free)
- Documentation for own HttpClient Implementation
- PSR18 Support #39 
- Documentation improvments
### Changed
- Move SplitSentences/Formatting Options to seperate Enum

## [2.2.0] - 2021-03-25
### Added
- Support new languages introduced by deepl (https://www.deepl.com/blog/20210316/)
- Support PHP8

## [2.1.2] - 2020-12-21
### Added
- Let the original exception bubble up within the RequestException (Thx @Mistralys)

## [2.1.1] - 2020-07-27
### Added
- Missing changelog update for 2.1.0

## [2.1.0] - 2020-07-20
### Added
- Support japanese and simplified chinese

## [2.0.0] - 2019-08-02
### Changed
- move Language Constants to separate Enum
- prettify classes/interfaces

## [1.4.0] - 2019-08-01
### Added
- new Feature File Translation

## [1.3.0] - 2019-04-12
### Added
- new Language PT/RU

### Changed
- added PHP7.3 Travis

## [1.2.0] - 2018-11-14
### Added
- Changelog

### Changed
- Deepl Endpoint to v2

## [1.1.0] - 2018-10-19
### Changed
- return typehints and typehints for scalar vars
- Minimum required php version: 7.2

## [1.0.1] - 2018-06-22
### Added
- Add missing methods in interface declarations

## [1.0.0] - 2018-06-04
### Added
- Initial Release
