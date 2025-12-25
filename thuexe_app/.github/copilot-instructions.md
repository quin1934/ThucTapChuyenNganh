# Project: thuexe_app - Laravel Application

This project is a Laravel application, likely a car rental or vehicle management system, given the model names like `Xe` (Vehicle), `DonThue` (Rental Order), `ChuXe` (Car Owner), and `KhachThue` (Renter). It follows standard Laravel conventions for structure and development.

## Big Picture Architecture

-   **MVC Pattern**: The application adheres to the Model-View-Controller (MVC) architectural pattern.
    -   **Models**: Located in `app/Models/`, these represent the business logic and interact with the database. Examples include `Xe.php`, `DonThue.php`, `User.php`.
    -   **Controllers**: Found in `app/Http/Controllers/`, these handle incoming requests, process user input, and interact with models and views. See `AdminController.php` for an example of:
        -   Direct model interaction (e.g., `Xe::count()`, `DonThue::where(...)`).
        -   Complex database queries with `where`, `sum`, `count`, `orderBy`, `take`, and `paginate`.
        -   Eager loading relationships (e.g., `DonThue::with(['xe', 'khachThue'])`).
        -   Rendering views with `return view('admin.dashboard', compact(...))`.
    -   **Views**: Stored in `resources/views/`, these are Blade templates responsible for rendering the user interface.
-   **Database**: The database schema is managed through Laravel Migrations (`database/migrations/`). The presence of numerous migration files indicates a well-defined and version-controlled database structure. Key tables seem to be `xes`, `don_thues`, `chu_xes`, `khach_thues`, and associated lookup/utility tables.
-   **Routing**: Web routes are defined in `routes/web.php`.
-   **API (Presumed)**: While not explicitly visible in the provided structure, a typical Laravel application might also have API routes defined in `routes/api.php` and corresponding API controllers.

## Critical Developer Workflows

-   **Local Development Server**: To run the application locally, use the Artisan command:
    ```bash
    php artisan serve
    ```
-   **Database Migrations**: To apply database migrations (create/alter tables), use:
    ```bash
    php artisan migrate
    ```
    To refresh the database (drop all tables and re-run migrations) and seed data:
    ```bash
    php artisan migrate:fresh --seed
    ```
-   **Composer**: Dependency management is handled by Composer. To install or update PHP dependencies:
    ```bash
    composer install
    composer update
    ```
-   **NPM/Yarn**: Frontend asset compilation is handled by npm/yarn and Vite. To install Node.js dependencies:
    ```bash
    npm install
    # or yarn install
    ```
    To compile assets:
    ```bash
    npm run dev
    # or yarn dev
    ```
    For production build:
    ```bash
    npm run build
    # or yarn build
    ```
-   **Artisan Commands**: Many administrative tasks are performed using Artisan. Explore available commands with:
    ```bash
    php artisan list
    ```

## Project-Specific Conventions and Patterns

-   **Model Naming**: Models are clearly named in Vietnamese (e.g., `ChuXe`, `DonThue`, `KhachThue`, `Xe`), following typical PascalCase conventions for classes.
-   **Migration Timestamps**: Migration files are prefixed with timestamps (e.g., `2025_11_21_072344_create_phan_loai_xes_table.php`), indicating standard Laravel migration usage.
-   **Database Seeding**: `database/seeders/DatabaseSeeder.php` is present, suggesting the use of seeders for populating the database with initial data.

## Integration Points and External Dependencies

-   **Composer Dependencies**: Listed in `composer.json` (PHP packages).
-   **NPM Dependencies**: Listed in `package.json` (JavaScript packages, likely for frontend build tools and libraries).
-   **Vite**: `vite.config.js` indicates that Vite is used for frontend asset compilation.

## Key Files and Directories

-   `app/Models/`: Contains all Eloquent models defining the application's data structure and relationships.
-   `app/Http/Controllers/`: Houses the application's controllers.
-   `database/migrations/`: Database schema definitions.
-   `routes/web.php`: Web route definitions.
-   `resources/views/`: Blade templates for the frontend.
-   `public/`: Web-accessible assets.
-   `config/`: Configuration files for various Laravel services.
-   `vite.config.js`: Frontend build configuration with Vite.
-   `composer.json`, `package.json`: Dependency management.
