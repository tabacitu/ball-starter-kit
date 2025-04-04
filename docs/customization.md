# Customization

This document provides guidance on how to customize and extend your BALL stack application to meet your specific requirements.

## Adding New Pages

Adding new pages to your application is straightforward:

### 1. Create a Livewire Component

Create a new Livewire component for your page:

```bash
php artisan make:livewire Pages/YourNewPage
```

This will create:
- `app/Livewire/Pages/YourNewPage.php`
- `resources/views/livewire/pages/your-new-page.blade.php`

### 2. Implement the Component

Edit the component class:

```php
<?php

namespace App\Livewire\Pages;

use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Your New Page')]
class YourNewPage extends Component
{
    // Add properties and methods as needed

    public function render()
    {
        return view('livewire.pages.your-new-page');
    }
}
```

### 3. Create the View

Edit the view file:

```blade
<div>
    <x-slot name="header">
        <div class="col">
            <h2 class="page-title">
              {{ __('Your New Page') }}
            </h2>
        </div>
    </x-slot>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <!-- Your content here -->
                </div>
            </div>
        </div>
    </div>
</div>
```

### 4. Add a Route

Add a route in the appropriate route file (e.g., `routes/web/app.php`):

```php
Route::middleware(['auth', 'verified'])->group(function () {
    // Existing routes...
    Route::get('your-new-page', YourNewPage::class)->name('your-new-page');
});
```

### 5. Add a Menu Item

Add a link to your new page in the menu (`resources/views/partials/menu.blade.php`):

```blade
<li class="nav-item {{ Route::is('your-new-page') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('your-new-page') }}">
        <span class="nav-link-icon d-md-none d-lg-inline-block">
            <!-- Icon here -->
        </span>
        <span class="nav-link-title">
            {{ __('Your New Page') }}
        </span>
    </a>
</li>
```

## Creating New Components

### Blade Components

To create a new Blade component:

1. Create a new view file in `resources/views/components/`:

```blade
{{-- resources/views/components/your-component.blade.php --}}
@props(['title' => null, 'description' => null])

<div {{ $attributes->merge(['class' => 'your-component']) }}>
    @if ($title)
        <h3 class="your-component-title">{{ $title }}</h3>
    @endif

    @if ($description)
        <p class="your-component-description">{{ $description }}</p>
    @endif

    {{ $slot }}
</div>
```

2. Use the component in your views:

```blade
<x-your-component title="Example Title" description="Example description">
    Content goes here
</x-your-component>
```

### Livewire Components

For more complex, interactive components:

1. Create a new Livewire component:

```bash
php artisan make:livewire Components/YourComponent
```

2. Implement the component class:

```php
<?php

namespace App\Livewire\Components;

use Livewire\Component;

class YourComponent extends Component
{
    public $title;
    public $description;

    public function mount($title = null, $description = null)
    {
        $this->title = $title;
        $this->description = $description;
    }

    public function render()
    {
        return view('livewire.components.your-component');
    }
}
```

3. Create the view:

```blade
<div>
    @if ($title)
        <h3 class="your-component-title">{{ $title }}</h3>
    @endif

    @if ($description)
        <p class="your-component-description">{{ $description }}</p>
    @endif

    {{ $slot }}
</div>
```

4. Use the component:

```blade
<livewire:components.your-component title="Example Title" description="Example description" />
```

## Modifying the User Model

### Adding New Fields

1. Create a migration to add new fields:

```bash
php artisan make:migration add_fields_to_users_table
```

2. Edit the migration:

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone_number')->nullable();
            $table->date('birth_date')->nullable();
            // Add more fields as needed
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['phone_number', 'birth_date']);
        });
    }
};
```

3. Run the migration:

```bash
php artisan migrate
```

4. Update the User model:

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone_number',
        'birth_date',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'birth_date' => 'date',
    ];
}
```

### Adding Relationships

To add relationships to the User model:

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    // Existing code...

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
}
```

## Customizing Authentication

### Modifying the Registration Form

1. Edit the registration form component (`app/Livewire/Forms/Auth/RegisterForm.php`):

```php
<?php

namespace App\Livewire\Forms\Auth;

use App\Services\AuthenticationService;
use Livewire\Component;

class RegisterForm extends Component
{
    public $name = '';
    public $email = '';
    public $password = '';
    public $password_confirmation = '';
    public $phone_number = ''; // New field

    // This can be customized by the parent component
    public $redirectTo = '/dashboard';

    protected AuthenticationService $authService;

    public function boot(AuthenticationService $authService)
    {
        $this->authService = $authService;
    }

    public function save()
    {
        // Register the user
        $user = $this->authService->register([
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
            'password_confirmation' => $this->password_confirmation,
            'phone_number' => $this->phone_number, // New field
        ]);

        // Log the user in
        $this->authService->login($user);

        // Redirect to the dashboard
        return redirect($this->redirectTo);
    }

    public function render()
    {
        return view('livewire.forms.auth.register-form');
    }
}
```

2. Update the registration form view (`resources/views/livewire/forms/auth/register-form.blade.php`):

```blade
<div>
    <form wire:submit="save">
        @csrf

        <x-form-input wire:model="name" :label="__('Name')" name="name" type="text" placeholder="Enter name" required autofocus autocomplete="name"  />
        <x-form-input wire:model="email" :label="__('Email Address')" name="email" type="email" placeholder="Enter email" required autocomplete="username" />
        <x-form-input wire:model="phone_number" :label="__('Phone Number')" name="phone_number" type="tel" placeholder="Enter phone number" autocomplete="tel" />
        <x-form-input wire:model="password" :label="__('Password')" name="password" type="password" placeholder="Enter password" required autocomplete="new-password" />
        <x-form-input wire:model="password_confirmation" :label="__('Confirm Password')" name="password_confirmation" type="password" placeholder="Confirm password" required autocomplete="new-password" />

        <div class="form-footer">
            <button type="submit" class="btn btn-primary w-100">{{ __('Register') }}</button>
        </div>
    </form>
</div>
```

3. Update the authentication service (`app/Services/AuthenticationService.php`):

```php
public function validateRegistrationData(array $data): array
{
    return validator($data, [
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
        'password' => ['required', 'confirmed', Rules\Password::defaults()],
        'phone_number' => ['nullable', 'string', 'max:20'],
    ])->validate();
}
```

## Integrating with Backpack

If you need an admin panel, you can integrate with [Backpack for Laravel](https://backpackforlaravel.com/):

1. Install Backpack:

```bash
composer require backpack/crud
php artisan backpack:install
```

2. Create CRUD controllers for your models:

```bash
php artisan backpack:crud user
```

3. Customize the CRUD controllers as needed.

This integration gives you a powerful admin panel with minimal effort.

## Adding Custom Middleware

To add custom middleware:

1. Create the middleware:

```bash
php artisan make:middleware YourMiddleware
```

2. Implement the middleware:

```php
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class YourMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Your logic here

        return $next($request);
    }
}
```

3. Register the middleware in `app/Http/Kernel.php`:

```php
protected $routeMiddleware = [
    // Existing middleware...
    'your-middleware' => \App\Http\Middleware\YourMiddleware::class,
];
```

4. Use the middleware in your routes:

```php
Route::middleware(['auth', 'your-middleware'])->group(function () {
    // Protected routes
});
```

## Customizing the Theme

### Changing Colors and Styles

To customize the Tabler theme:

1. Create a custom CSS file:

```css
/* public/css/custom.css */
:root {
    --tblr-primary: #3b7ddd;
    --tblr-primary-rgb: 59, 125, 221;
    /* Override other variables as needed */
}

/* Add your custom styles here */
```

2. Include the custom CSS in your layout:

```blade
<link rel="stylesheet" href="{{ asset('css/custom.css') }}">
```

### Using a Different Theme

If you want to use a different theme entirely:

1. Replace the Tabler CSS and JS in `resources/views/partials/styles.blade.php` and `resources/views/partials/scripts.blade.php`
2. Update the layout files to match the new theme's structure
3. Update the components to use the new theme's classes

Remember that this is your application, and you have complete control over every aspect of it. Feel free to modify any part to suit your specific needs.
