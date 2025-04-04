# Architecture

This document explains the architecture of your BALL stack application, including the directory structure, design patterns, and how different components work together.

## The BALL Stack

Your application is built using the BALL stack:

- **B**ootstrap (through the excellent Tabler HTML template)
- **A**s-little-js-as-possible
- **L**aravel
- **L**ivewire

This stack was chosen not only for its simplicity and developer experience but also for long-term maintainability. By using front-end technologies only in components (not at the core level), dependencies become easier to manage in the future. This architecture allows you to change from one framework to another relatively easily since your entire application doesn't depend on a single technology choice. Instead, the "core dependencies" are battle-tested long-term technologies like Laravel, Bootstrap, and vanilla JS that have proven stability and longevity.

### Bootstrap/Tabler

The UI is powered by [Tabler](https://tabler.io/), a free and open-source dashboard template with responsive design based on Bootstrap 5. Despite being free, Tabler provides features comparable to most paid templates:

- A clean, modern design
- 300+ UI components
- Responsive layouts
- Consistent styling

The Tabler CSS and JS are included from CDN in the layout files, making it easy to update or replace if needed.

### As-little-js-as-possible

The application follows a philosophy of using as little JavaScript as possible. This is achieved by:

- Using Livewire for interactivity instead of custom JavaScript
- Including only essential JavaScript libraries (Tabler's core JS)
- Avoiding complex client-side frameworks

This approach results in faster page loads, simpler code, and better maintainability.

### Laravel

The application is built on Laravel, providing:

- A robust routing system
- Eloquent ORM for database interactions
- Blade templating engine
- Authentication and authorization
- Form validation
- Error handling

### Livewire

[Livewire](https://livewire.laravel.com/) is used for adding dynamic, reactive features to the application without writing JavaScript. Livewire components are used for:

- Forms (login, registration, account settings)
- Interactive pages (dashboard, user list)
- Dynamic UI elements

## Directory Structure

The application follows Laravel's standard directory structure with some additional organization:

### Routes

Routes are organized into separate files based on their purpose:

- `routes/web.php` - Main entry point that includes other route files
- `routes/web/app.php` - Application routes (dashboard, settings)
- `routes/web/auth.php` - Authentication routes (login, register)
- `routes/web/marketing.php` - Marketing routes (home, pricing)

This organization makes it easy to understand and maintain the routes as your application grows.

### Controllers

Controllers are kept minimal and focused on their specific responsibilities:

- `app/Http/Controllers/AuthController.php` - Handles authentication-related requests
- `app/Http/Controllers/AccountSettingsController.php` - Manages account settings

### Services

Business logic is encapsulated in service classes:

- `app/Services/AuthenticationService.php` - Authentication logic
- `app/Services/UserAccountService.php` - User account management logic

This service pattern helps keep controllers thin and makes business logic reusable and testable.

### Livewire Components

Livewire components are organized by type:

- `app/Livewire/Forms/` - Form components
  - `app/Livewire/Forms/Auth/` - Authentication forms
  - `app/Livewire/Forms/Account/` - Account settings forms
- `app/Livewire/Pages/` - Full page components

### Views

Views are organized to match the component structure:

- `resources/views/layouts/` - Layout templates
- `resources/views/components/` - Blade components
- `resources/views/livewire/` - Livewire component views
  - `resources/views/livewire/forms/` - Form component views
  - `resources/views/livewire/pages/` - Page component views
- `resources/views/partials/` - Reusable view partials
- `resources/views/auth/` - Authentication views

## Design Patterns

### Service Pattern

The application uses the service pattern to encapsulate business logic. Services are responsible for:

- Validating input data
- Performing business operations
- Interacting with the database through models

This pattern keeps controllers and Livewire components focused on handling requests and rendering views.

### Repository Pattern (Optional)

For more complex applications, you might want to add repositories to abstract database interactions. This would involve:

- Creating repository interfaces
- Implementing concrete repositories
- Injecting repositories into services

### Component-Based UI

The UI is built using a component-based approach with:

- Blade components for static UI elements
- Livewire components for interactive elements

This approach promotes reusability and consistency across the application.

## Extending the Architecture

As your application grows, you might want to extend the architecture:

- Add more service classes for new business domains
- Create repositories for complex database interactions
- Add more Livewire components for new features
- Implement domain-driven design for large applications

Remember that this architecture is a starting point, and you should adapt it to your specific needs as your application evolves.
