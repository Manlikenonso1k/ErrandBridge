# ErrandBridge

ErrandBridge is a Laravel 12 multi-panel marketplace app for sender/runner errands,
built on Filament 3 with role-based access.

## Stack

- Laravel 12
- Filament 3 (admin, sender, runner panels)
- Livewire 3
- Spatie Permission
- Spatie MediaLibrary
- Laravel Reverb
- DomPDF
- Intervention Image
- SQLite (local)

## Main URLs

- /
- /dashboard (role redirect)
- /admin/login
- /sender/login
- /sender/register
- /runner/login
- /runner/register

## Panel Features

- Admin panel: platform settings, KYC approvals
- Sender panel: create/manage own errands, quick post page
- Runner panel: accept/start/complete errands, map placeholder page
- Role-gated panel access using Filament user access checks + middleware

## Seeder Accounts

- admin@errandbridge.com / password
- sender@errandbridge.com / password
- runner@errandbridge.com / password

## Local Setup

```bash
composer install
php artisan migrate:fresh --seed
php artisan serve
```

## Test

```bash
php artisan test
```

## Troubleshooting: Changes Not Showing (Stubborn Cache)

If code changes do not appear immediately (for example route/middleware updates), use this full reset flow.

1. Stop any running Laravel dev server for this project.
2. Run a full clear:

```bash
php artisan optimize:clear
php artisan route:clear
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

3. Start a fresh server:

```bash
php artisan serve --host=127.0.0.1 --port=8000
```

4. Hard refresh browser once (`Ctrl+F5`) if old UI is still visible.

Quick verification example:

```bash
curl -I http://127.0.0.1:8000/runner/register
```

Expected status for a healthy runner registration page: `200 OK`.

Note: local PHP startup warnings about `pdo_firebird`/SNMP may still appear on some machines; these are non-blocking for Laravel route/cache operations.
