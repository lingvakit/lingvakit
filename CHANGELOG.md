# Changelog

---

## [2.2.0] - 2026-08-07
### Added:
* Create and add new question to questions group via modal window form

---

## [2.1.1] - 2026-07-29
### Fixed:
* Quiz migration to microservice rules

---

## [2.1.0] - 2026-07-28
### Added:
* Display questions group details page
* Endpoint for changing correct question answer
* Change question answers (for single choice) on React page in admin dashboard

---

## [2.0.4] - 2026-07-17
### Fixed:
*  Fix error on create question group form
*  Fix 401 error while updating quiz via React UI

---

## [2.0.3] - 2026-07-16
### Fixed:
* Display question type on quiz page in admin panel
* Display quizzes on course page in admin panel

---

## [2.0.2] - 2026-07-13
### Fixed:
* Optimize database requests for getting course details

---

## [2.0.1] - 2026-07-07
### Fixed:
* Added authentification for quiz:migrate command script 

---

## [2.0.0] - 2026-07-06
### Added:
* Created a command for migration all quizzes to microservice "php artisan quiz:migrate"
* Code refactoring

---

## [1.37.2] - 2026-06-15
### Fixed:
* Attaching media files in lesson and quiz forms
* Fix ratio for images and video if added via CKEditor

---

## [1.37.1] - 2026-06-09
### Fixed:
* Attach media file to relevant place of form

---

## [1.37.0] - 2026-06-08
### Optimized:
* Display image thumbnail relevant for block container in modal window

---

## [1.36.1] - 2026-06-05
### Fixed:
* Impossible unattach file after media file was attached in any place of form

---

## [1.36.0] - 2026-06-04
### Added:
* Generate questions in question group create form with GigaChat

---

## [1.35.0] - 2026-06-02
### Added:
* Search media files in modal window

---

## [1.34.0] - 2026-06-02
### Added:
* Display skeleton in modal window while files uploading
* Button "Load more" for uploading more files

---

## [1.33.0] - 2026-06-02
### Added:
* Upload media files via modal window

---

## [1.32.0] - 2026-05-27
### Added:
* Display question group on quiz page in react ui

---

## [1.31.0] - 2026-05-27
### Changed:
* Rename main branch to "main"

---

## [1.30.1] - 2026-05-26
### Added:
* Make page for creating questions group in React UI

---

## [1.28.0] - 2026-05-18
### Added:
* Page with quiz common details
* Endpoint for creating question's group
* Add UI modal window for generating lesson content from gigachat

---

## [1.27.0] - 2026-05-04
### Style:
* Update style for quizzes grid

---

## [1.26.0] - 2026-04-30
### Added:
* Updating modules via modal window

---

## [1.25.0] - 2026-04-27
### Added:
* Media types for attaching files to CKEditor

---

## [1.24.0] - 2026-04-22
### Removed:
* Validator for email domain for register new users

---

## [1.23.0] - 2026-04-21
### Refactoring:
* Backend API for React UI
### Added:
* Add form for creating quiz in react UI
* Add form for updating quiz in react UI

---

## [1.22.1] - 2026-04-19
### Fixed:
* Field 'imageUrl' returns image path instead media file id
* Publish date field runs error with carbon date

---

## [1.22.0] - 2026-04-14
### Added:
#### Functionality for courses
* Course pages:
  * List of courses
  * Course details
  * Create course
* Course modules:
  * Create module via modal window
* Lessons:
  * Page for creating new lesson
  * Page for updating lesson
  * Delete lesson via button on course page
* Lesson form:
  * Generating fake lesson content on create/update lesson pages

---

## [1.21.5] - 2026-03-12
### Fixed:
* Autoload helpers

---

## [1.21.4] - 2026-03-11
### Fixed:
* Deploy config

---

## [1.21.0] - 2026-03-11
### Added:
* Course pages via react

---

## [1.20.5] - 2026-01-30
### Fixed:
* Uploading PDF to editor

---

## [1.20.4] - 2026-01-22
### Fixed:
* Decrease media items on page for improving loading speed

---

## [1.20.3] - 2025-12-23
### Fixed:
* improve speed for showing images via lazy load

---

## [1.20.2] - 2025-12-23
### Fixed:
* improve speed for showing images

---

## [1.20.0] - 2026-01-10
### Added:
* Add laravel debugger for development

### Fixed:
* Uploading images

---

## [1.19.0] - 2025-12-23
### Updated:
* Documents

---

## [1.18.0] - 2025-12-14
### Info:
* Attach audio and video from editor

---

## [1.17.0] - 2025-12-13
### Info:
* State before creating MS Quiz

---

## [1.16.1] - 2025-11-12
### Fixed:
* JWT Auth

---

## [1.16.0] - 2025-11-12
### Added:
* JWT Auth

---

## [1.15.0] - 2025-11-10
### Updated:
* Composer packages

---

## [1.14.0] - 2025-10-16
### Changed:
* Upload media files via MS Media

### Fixed:
* Showing video on frontend


---

## [1.13.2] - 2025-10-15
### Fixed:
* Migrating only video files to MS Media

---

## [1.13.1] - 2025-10-15
### Fixed:
* Migrating video files to MS Media

---

## [1.13.0] - 2025-10-15
### Updated:
* Composer

---

## [1.12.2] - 2025-10-14
### Fixed:
* Lesson page

---

## [1.12.0] - 2025-10-03
### Changed:
* List of available mail domains

---

## [1.11.4] - 2025-09-25
### Fixed:
* Display video files

---

## [1.11.0] - 2025-09-21
### Added:
* Command for migrating media files

---

## [1.10.0] - 2025-08-26
### Changed:
* Landing page content

---

## [1.9.0] - 2025-08-03
### Added:
* Notification for password reset

---

## [1.8.0] - 2025-08-03
### Updated:
* Set new logo for emails

### Removed:
* Unused images from emails

---

## [1.7.0] - 2025-08-02
### Added:
* Logic for sending email if new user registered
* Logic for sending email as verification

---

## [1.6.1] - 2025-08-01
### Fixed:
* Fix settings for deploy on PHP8.3

---

## [1.6.0] - 2025-07-28
### Added:
* Kafka producer
* Send notification if user registered

### Updated:
* Updated PHP version to 8.3

---

## [1.5.0] - 2025-07-14
### Added
* Added link to media files page

---

## [1.4.0] - 2025-07-06
### Removed
* Removed articles and help links from main page

---

## [1.3.3] - 2025-06-25
### Fixes
* Fix deploy script

---

## [1.3.2] - 2025-06-25
### Fixes
* Fix deploy script

---

## [1.3.1] - 2025-06-25
### Fixes
* Fix deploy script

---

## [1.3.0] - 2025-06-11
### Added
* Run scripts after deploy

---

## [1.2.0] - 2025-06-11
### Changed
* Deploy runner on the hosting

---

## [1.1.1] - 2025-06-05
### Fixed
* Deploy runner

---

## [1.1.0] - 2025-06-05
### Changed
* Change logo
* Set auto deploy
* Prepare code to deploy

---

## [1.0.0]
### Project moved to VDS