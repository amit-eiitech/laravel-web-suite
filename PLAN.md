# Eii Web Suite — Product & Technical Plan

**Package:** `eii/laravel-web-suite`    
**Vendor:** `eii`  
**Primary use:** Internal reusable toolkit for Eii Tech Solutions client websites  
**Initial admin UI:** Optional generated Filament 5 resources  
**Status:** Initial architecture agreed; core modules scaffold in progress

---

## 1. Product purpose

Create a reusable Laravel Composer package that eliminates repeated backend work when building business/corporate websites.

The package is a **business website backend companion**, not a full CMS and not a page builder.

Eii develops and configures the website. The client receives a maintainable application and can manage the business content. The developer may use generated Filament resources or build a completely custom admin UI against the package's models and services.

Core principles:

1. Reusable business functionality, not a one-size-fits-all website.
2. Core Laravel models/services must not depend on Filament.
3. Filament 5 is an optional UI adapter.
4. Generated resources are copied into the host application and remain editable.
5. No static Pages CMS, frontend scaffolding, header/footer menu manager, portfolio, or testimonials in v1.
6. Optional modules must be independently installable/usable.
7. AI capabilities are modularized in a separate standalone AI package.

## 2. Confirmed scope

### Content modules

| Module | Required | Notes |
|---|---:|---|
| News | Yes | Articles, slug, content, excerpt, image, status, publication date |
| Events | Yes | Start/end, location, registration URL, status |
| Recruitment | Yes | Position, department, employment type, location, salary range, requirements, application details |
| FAQ | Yes | Question, answer, ordering, category, publication state |
| Blog | Optional | Similar content lifecycle to News, separate model/table |
| Categories | Yes | Shared category taxonomy, scoped to content type |
| Tags | Optional / later | Shared polymorphic tags |

### Explicit exclusions from v1

- Static pages table / Pages CMS
- Frontend scaffolding
- Header/footer menu items or menu manager
- Portfolio
- Testimonials
- Visual page builder
- Custom admin framework
- E-commerce
- Newsletter campaigns

### Contact and security

- Multiple contact form definitions.
- Contact submissions stored in the database.
- Configurable fields and validation.
- Admin/customer email notifications.
- Cloudflare Turnstile and Google reCAPTCHA adapters.
- Honeypot, rate limiting, attachment validation and privacy consent.
- Reuse Eii's existing CAPTCHA package where technically appropriate rather than duplicating CAPTCHA code.

### SEO

- SEO metadata related to content records via polymorphic relationship.
- SEO defaults in Spatie Settings.
- Meta title and description.
- Canonical URL.
- Robots directives.
- Open Graph and social image.
- XML sitemap.
- Redirect management (301/302/410).
- JSON-LD helpers for Organization, Article, Event, JobPosting and FAQPage where appropriate.
- Breadcrumb data/helpers (not frontend templates).
- Multilingual/hreflang support later.

### Website settings

Use Spatie Laravel Settings for one-time website-wide configuration, not for content collections.

Suggested settings classes:
- `GeneralSettings`: site name, logo, favicon.
- `CompanySettings`: company name, representative, address, registration details.
- `ContactSettings`: phone, email, business hours.
- `SocialSettings`: social URLs.
- `LocalizationSettings`: language, timezone, date format.
- `SeoSettings`: default title, description, fallback social image.
- `NotificationSettings`: notification recipients and preferences.

## 3. Filament and custom UI strategy

### Filament

- Support Filament 5 only.
- Filament is an optional Composer integration, not a hard dependency of the core.
- Provide generated starter resources for News, Events, Recruitment, FAQ, Blog, Contact Forms, Contact Submissions, SEO Metadata and Redirects.
- Generated resources are copied to the host application's `app/Filament/Resources`.
- The generator must not overwrite existing files unless an explicit `--force` option is supplied.
- Generated resources are application-owned and freely editable.

### Custom UI

Developers can skip the Filament generator entirely.

They can build a custom interface using:
- Eloquent models and relationships.
- Domain/service classes.
- Validation rules and request objects (to be added).
- Public query scopes / published content helpers.

The package must not require Filament classes to be loaded when Filament is not installed.

### Architecture

`Core / Models / Services / Database`  
↓  
`Optional Filament 5 adapter and resource generator`

Filament must not own the business rules or persistence logic.

## 4. Database plan

Initial tables:

| Table | Purpose |
|---|---|
| `news` | News content |
| `events` | Events |
| `job_posts` | Recruitment |
| `blog_posts` | Optional blog content |
| `faqs` | FAQ entries |
| `categories` | Categories scoped by module |
| `categorizables` | Polymorphic categorizable relationships |
| `taggables` | Polymorphic tag relationships, later |
| `contact_forms` | Form definitions |
| `contact_submissions` | Enquiries |
| `seo_metadata` | Polymorphic SEO metadata |
| `seo_redirects` | Redirect rules |

Spatie Settings uses its own settings tables/migrations.

Use additive, reversible migrations. Never automatically drop client content when a module is disabled.

## 5. Artisan commands

Initial commands:
- `php artisan eii:install`
- `php artisan eii:status`
- Later: `eii:module`, `eii:make-form`

Installer should publish config only if absent and explain that migrations must be run.

Generator:
- copies resources and pages into application code;
- detects Filament 5;
- refuses to overwrite unless `--force`;
- supports modules individually;
- no frontend views are generated.

## 6. Dependencies

Required:
- PHP ^8.2
- Laravel 12 or 13
- Spatie Laravel Settings ^3.10

Optional:
- Filament ^5.0
- Filament Spatie Settings plugin ^5.0
- Spatie Media Library
- Spatie Permission

## 7. Development roadmap

### Phase 1 — Package foundation
- [x] Composer package skeleton
- [x] Service provider
- [x] Config file
- [x] Initial migrations and models
- [x] Installer/status/generator command with module-specific initial Filament 5 stubs
- [x] Product plan document
- [x] Initial Spatie Settings classes and settings migration
- [ ] Feature tests and static analysis
- [ ] Validate migrations against MySQL, PostgreSQL and SQLite

### Phase 2 — Content modules
- Complete CRUD fields and scopes.
- Add categories and publication workflows.
- Add policies and authorization hooks.
- Add model factories and tests.

### Phase 3 — Contact
- Form definitions and field schemas.
- Submission validation and storage.
- CAPTCHA adapters.
- Email notifications and rate limiting.
- Attachment security.

### Phase 4 — SEO
- SEO relationship and defaults.
- Metadata helpers.
- Sitemap.
- Redirect middleware.
- JSON-LD helpers and tests.

### Phase 5 — Filament 5 UI
- Full resources, pages, relation managers and settings pages.
- Generated resource stubs.
- Panel integration documentation.
- Confirm no Filament class is loaded in non-Filament installs.

### Phase 6 — Release readiness
- CI across supported PHP/Laravel combinations.
- Pest tests.
- PHPStan/Larastan.
- Pint.
- Security review.
- README and upgrade guide.
- Packagist release.

## 8. Important implementation rules

1. No frontend scaffolding.
2. No static pages table.
3. No header/footer menu manager.
4. No portfolio or testimonials in v1.
5. Filament is optional and v5-only.
6. Business logic belongs outside Filament.
7. Generated UI files belong to the application and must not be overwritten silently.
