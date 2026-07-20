# Setup & Configuration (Quick Guide)

This document contains the essential steps to configure and run the Community Management System locally and in production. The repository includes helpers (sanitizer, protected downloads, chunked export class), but you must configure some environment services and install a few packages.

1) Install PHP dependencies

- Install Composer dependencies:

  composer install

- Recommended packages (optional but strongly recommended):

  composer require mews/purifier maatwebsite/excel barryvdh/laravel-dompdf

  - mews/purifier: production-grade HTML sanitization
  - maatwebsite/excel: chunked, queued exports
  - barryvdh/laravel-dompdf: PDF generation for minute downloads

2) Environment variables

- Copy .env.example to .env and configure DATABASE_URL, MAIL, AWS (if using S3), and QUEUE_CONNECTION.

  cp .env.example .env
  php artisan key:generate

- Add these values (example):

  FILESYSTEM_DRIVER=local
  FILESYSTEM_PRIVATE=local_private
  QUEUE_CONNECTION=database
  MAIL_MAILER=log

3) Filesystems (private attachments)

- The repository includes config/filesystems.php with a local_private disk option pointing to storage/app/private. Create the directory and set permissions:

  mkdir -p storage/app/private
  chmod -R 775 storage

- If you prefer S3 for private attachments, configure an S3 disk in .env and set FILESYSTEM_PRIVATE to that disk name.

- If you need public attachments, run:

  php artisan storage:link

4) Queue worker

- For queued notifications and queued exports, configure the queue driver in .env (database or redis recommended).

- Database driver setup:

  php artisan queue:table
  php artisan migrate
  php artisan queue:work

5) Database migrations

- Run migrations:

  php artisan migrate

- The repository added an index migration to improve performance. Run migrations after setting up the DB.

6) Optional packages

- If you installed mews/purifier, you can remove reliance on the built-in HtmlSanitizer and use Purifier::clean() which offers better sanitization defaults.

7) Exports

- The MeetingsExport class is added in app/Features/Meetings/Exports/MeetingsExport.php. It is chunked and implements ShouldQueue. To run exports safely:

  - Create a controller method that dispatches (new MeetingsExport())->queue('exports/meetings.xlsx');
  - Ensure queue worker is running.

8) Tests

- Example test skeletons were added. Run the test suite with:

  ./vendor/bin/phpunit

9) Security notes

- The app includes a conservative HtmlSanitizer for basic XSS protection, but for HTML fields install HTMLPurifier for robust sanitization.
- Attachments are stored on a configured private disk and served only after authorization checks.

If you want, I can also:

- Add CI workflow files to run tests, run static analysis and run migrations in staging.
- Add templates for queued export completion notifications and stored download links.

