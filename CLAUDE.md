# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

Kode Perfumaria — a Laravel 12 + Livewire 4 perfume catalog with a public storefront and admin dashboard.

## Development Commands

Comandos do Artisan e Composer devem ser executados **dentro do container Docker**:

```bash
docker exec -it php bash
cd kode
```

A partir daí, rode os comandos normalmente:

```bash
# Start all dev servers (Laravel + queue + logs + Vite) concurrently
composer dev

# Run tests
composer test
php artisan test
php artisan test --filter=TestName   # single test

# Frontend (rodar fora do container, na pasta do projeto)
npm run dev        # Vite dev server
npm run build      # production build

# Code formatting
./vendor/bin/pint

# Initial project setup
composer setup     # install, key:generate, migrate, npm install + build
```

## Architecture

### Request Flow
- Public routes (`/`, `/catalog`, `/parfum/{name}`) → `HomeController`, `CatalogController`, `ParfumController`
- Auth routes (`/login`, `/logout`) → `LoginController`
- Admin routes (`/admin/*`) → protected by `auth` + `EnsureUserIsAdmin` middleware → `DashboardController`, `PerfumeController`, `UserController`, `CatalogSettingsController`

### Livewire Components
Interactive state lives in `app/Livewire/`:
- `CatalogGrid` — product listing with search, multi-axis filtering (family, concentration, occasion, intensity), sorting, and pagination
- `ProductCarousel` — product carousel for the homepage

### Models
`Perfume` is the core entity. It relates to:
- `PerfumeImage`, `PerfumeVariant`, `PerfumeReview` (product details)
- `FragranceFamily`, `Concentration`, `Occasion`, `Intensity` (taxonomy — managed via `CatalogSettingsController`)
- `Tag`, `PerfumeCollection` / `PerfumeCollectionItem` (categorization)

`User` has an admin flag enforced by `EnsureUserIsAdmin` middleware.

### Views
- `resources/views/layouts/public.blade.php` and `admin.blade.php` — two root layouts
- Components live in `resources/views/components/`
- Admin views under `resources/views/admin/`, public views at root level

### Styling
Tailwind CSS v4 with a custom brand theme defined in `resources/css/app.css`:
- `--color-green: #065037` (primary)
- `--color-gold: #c7a15a` (accent)
- `--color-white-brand: #e6f3ff` (background)
- Font: Montserrat

Icons: `mallardduck/blade-lucide-icons` — use `<x-lucide-{icon-name} />`.

### Database
MySQL. Sessions, cache, and queues all use the `database` driver. Run migrations with `php artisan migrate`.
