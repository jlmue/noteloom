# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

This is a Laravel 12 application with Livewire 3.6 for reactive frontend components. The project uses:
- PHP 8.2+
- Pest for testing
- Tailwind CSS 4.0
- Vite for asset compilation
- SQLite as the default database

### Project Context

The goal is to demonstrate proficiency in Laravel and modern frontend frameworks by building a note management application within 6-8 hours.

**Additional Details:**
- Include: Repository link and README file

## Application Requirements

### Core Functionality
Build a web application for managing notes (Notizen) with full CRUD functionality:

**Required Features:**
- Display all existing notes in an overview
- Create new notes
- Edit existing notes
- Delete notes
- Responsive design (mobile-friendly)

**Note Model Structure:**
Each note must contain:
- `title` (string) - Note title
- `content` (text) - Note content
- `created_at` (timestamp) - Creation date
- `is_important` (boolean, nullable/optional) - Flag to mark important notes

### Development Constraints

**CRITICAL - No External Packages:**
- Use ONLY Laravel's built-in features and standard libraries
- DO NOT install any third-party packages beyond what's already in composer.json
- Livewire 3.6 is already included and is the chosen frontend framework
- All functionality must be implemented using Laravel/Livewire core features

**Laravel Conventions:**
- Follow strict Laravel conventions for Models, Controllers, Routing, and Migrations
- Use Resource Controllers for CRUD operations
- Follow RESTful routing principles
- Use Eloquent ORM for database operations
- Follow Laravel naming conventions (singular model names, plural table names, etc.)

### Evaluation Criteria

The solution will be evaluated on:

1. **Code Quality & Structure (High Priority)**
   - Strict adherence to Laravel conventions
   - Clean separation of concerns between backend and frontend
   - Readable, maintainable code structure
   - Proper use of Livewire component patterns

2. **Functionality (High Priority)**
   - Complete CRUD implementation for notes
   - Correct data persistence and retrieval
   - Proper handling of the `is_important` flag
   - Error-free operation

3. **Frontend Implementation (High Priority)**
   - Intuitive, user-friendly interface
   - Stable state handling in Livewire components
   - Responsive design that works on mobile devices
   - Optional: Visual highlighting of important notes
   - Optional: Filter to show only important notes

4. **Documentation (Required)**
   - Clear README.md with installation instructions
   - Startup/usage instructions
   - Any necessary setup steps

### Bonus Features (Optional)

These features are optional but demonstrate additional competency:
- **Search functionality** - Search notes by title or content
- **Filter functionality** - Filter notes (e.g., show only important notes)
- **Sorting** - Sort by creation date or importance
- **SPA with API** - Implement as single-page application with API communication
- **Tests** - Unit tests or Feature tests for note functionality

## Development Commands

### Initial Setup
```bash
composer setup
```
This runs the complete setup: installs dependencies, creates .env, generates app key, runs migrations, and builds assets.

### Development Server
```bash
composer dev
```
Starts a multi-process development environment with:
- PHP development server (http://localhost:8000)
- Queue worker (database queue connection)
- Log tailing (Pail)
- Vite dev server with hot module replacement

Alternatively, run services individually:
```bash
php artisan serve          # Development server only
npm run dev                # Vite dev server only
php artisan queue:listen   # Queue worker only
php artisan pail           # Log viewer only
```

### Testing
```bash
composer test              # Run all tests
php artisan test           # Alternative test command
php artisan test --filter=ExampleTest  # Run specific test
```

The test suite uses Pest and is configured with:
- Unit tests in `tests/Unit/`
- Feature tests in `tests/Feature/`
- In-memory SQLite database for testing

### Code Quality
```bash
vendor/bin/pint            # Run Laravel Pint code formatter
vendor/bin/pint --test     # Check code style without fixing
```

### Asset Building
```bash
npm run build              # Production build
npm run dev                # Development build with HMR
```

### Artisan Commands for Note Feature

```bash
# Create Note model with migration
php artisan make:model Note -m

# Create Livewire component
php artisan make:livewire NotesList
php artisan make:livewire NoteForm

# Run migrations
php artisan migrate

# Rollback last migration (if needed during development)
php artisan migrate:rollback

# Fresh migration (drops all tables and re-migrates)
php artisan migrate:fresh

# Create factory for Note model (optional, for testing/seeding)
php artisan make:factory NoteFactory

# Create seeder (optional)
php artisan make:seeder NoteSeeder
```

## Architecture

### Livewire Components
Livewire components are located in `app/Livewire/` with corresponding Blade views in `resources/views/livewire/`. Components follow the standard Livewire structure:
- PHP class in `app/Livewire/ComponentName.php`
- Blade template in `resources/views/livewire/component-name.blade.php`

Example: `LoginForm` component → `app/Livewire/LoginForm.php` + `resources/views/livewire/login-form.blade.php`

### Queue Configuration
The application uses database-backed queues (`QUEUE_CONNECTION=database`). When working with queued jobs:
- Jobs are stored in the `jobs` table (migration: `0001_01_01_000002_create_jobs_table.php`)
- Run `php artisan queue:listen` during development
- Failed jobs are tracked in the `failed_jobs` table

### Session & Cache
Both sessions and cache use database drivers by default:
- `SESSION_DRIVER=database`
- `CACHE_STORE=database`

Relevant migrations are in `database/migrations/0001_01_01_000001_create_cache_table.php`.

### Frontend Assets
Vite processes assets defined in `vite.config.js`:
- Entry points: `resources/css/app.css` and `resources/js/app.js`
- Tailwind CSS 4.0 is integrated via Vite plugin
- Livewire automatically handles JavaScript dependencies

### Testing Configuration
Pest is configured in `tests/Pest.php`:
- Feature tests extend `Tests\TestCase`
- Database refresh is available but commented out (uncomment in Pest.php if needed)
- Custom expectations and helper functions can be added to Pest.php

## Database

The default configuration uses SQLite (`database/database.sqlite`). To switch to MySQL/PostgreSQL, update `.env`:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

## Implementation Guidance for Note Management

### Recommended Approach

**Database Layer:**
1. Create a `Note` model with migration
2. Migration should include: `title`, `content`, `is_important`, and timestamps
3. Use `php artisan make:model Note -m` to create model and migration together

**Livewire Components:**
Since this is a Livewire-based application, implement CRUD using Livewire components:

1. **Notes List Component** (`NotesList.php`)
   - Display all notes
   - Handle delete operations
   - Optionally: filtering and sorting
   - Real-time updates with Livewire reactivity

2. **Create/Edit Note Component** (`NoteForm.php` or separate components)
   - Form for creating new notes
   - Form for editing existing notes
   - Real-time validation
   - Handle `is_important` checkbox

**Routing:**
- Keep routes simple - typically just one or two routes for the main view(s)
- Let Livewire handle the interactions (no need for full RESTful routes)
- Example: `Route::get('/', NotesList::class);`

**Validation:**
- Use Livewire's `#[Validate]` attributes or `$rules` property
- Required: `title` and `content`
- Optional: `is_important` (defaults to false)

### Model Requirements

The `Note` model should:
- Use mass assignment protection (`$fillable` or `$guarded`)
- Include: `title`, `content`, `is_important`
- Use timestamp management (enabled by default)
- Consider adding a cast for `is_important` to boolean

Example:
```php
protected $fillable = ['title', 'content', 'is_important'];
protected $casts = ['is_important' => 'boolean'];
```

### UI/UX Considerations

- Use Tailwind CSS (already configured) for styling
- Ensure responsive design with Tailwind's responsive classes
- Visual distinction for important notes (e.g., different background, icon, badge)
- Confirmation before deleting notes (use browser confirm or Livewire confirmation)
- Consider using Livewire's loading states for better UX

### Testing Notes

If implementing bonus tests:
- Test Note model CRUD operations
- Test Livewire component interactions
- Test validation rules
- Use `RefreshDatabase` trait in tests (uncomment in `tests/Pest.php`)

## Important Notes

- The project uses Composer scripts for common workflows—prefer `composer dev` over manually starting individual services
- Livewire components should be created using `php artisan make:livewire ComponentName`
- When adding new Livewire components, ensure views are placed in `resources/views/livewire/`
- The development workflow expects `concurrently` (npm package) to run multiple services simultaneously
- **CRITICAL**: Do not install any packages beyond what's already in `composer.json` - this is a hard requirement for the job application task
