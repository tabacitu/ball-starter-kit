# Components

This document provides an overview of the reusable components included in your BALL stack application and how to use them effectively.

## Blade Components

Blade components are reusable UI elements that help maintain consistency across your application. They are located in the `resources/views/components/` directory.

### Form Input Component

The form input component (`form-input.blade.php`) provides a standardized way to create form inputs with labels and error handling.

**Usage:**

```blade
<x-form-input
    name="email"
    type="email"
    label="Email Address"
    placeholder="your@email.com"
    required
    wire:model="email"
/>
```

**Parameters:**

- `name` (required): The input name attribute
- `type` (optional, default: "text"): The input type (text, email, password, etc.)
- `label` (optional): The input label (defaults to capitalized name if not provided)
- `placeholder` (optional): The input placeholder text
- `required` (optional): Whether the input is required
- `wire:model` (optional): Livewire model binding
- Any other HTML attributes are passed to the input element

**Error Handling:**

The component automatically displays validation errors for the input field.

**Implementation:**

```blade
@php
    $errors = is_array($errors) ? $errors : $errors->get($attributes['name']);
    $attributes = $attributes->merge([
        'class' => 'form-control ' . ($errors ? 'is-invalid' : ''),
        'value' => old($attributes['name']),
        'type' => 'text',
        'id' => $attributes['name'].'-input',
    ])->except(['errors']);
@endphp

<div class="mb-3">
    @unless ($attributes['type'] === 'hidden')
    <label class="form-label text-capitalize {{ $attributes['required'] ? 'required':'' }}" for="{{ $attributes['id'] }}">{{  $attributes['label'] ?? ucfirst($attributes['name']) }}</label>
    @endunless
    <input {{ $attributes }} />

    @if (count($errors))
        <div class="invalid-feedback">
            @foreach ($errors as $error)
                {{ $error }} <br>
            @endforeach
        </div>
    @endif
</div>
```

### Alert Component

The alert component (`alert.blade.php`) provides a standardized way to display alert messages.

**Usage:**

```blade
<x-alert
    type="success"
    title="Success!"
    text="Your changes have been saved."
    :dismissible="true"
/>
```

**Parameters:**

- `type` (optional, default: "success"): The alert type (success, warning, danger, info)
- `title` (optional): The alert title
- `text` (optional): The alert text
- `dismissible` (optional, default: true): Whether the alert can be dismissed
- `important` (optional, default: false): Whether the alert is important (changes styling)
- `icon` (optional, default: true): Whether to show an icon
- `class` (optional): Additional CSS classes

**Implementation:**

```blade
@php
    $type = $type ?? 'success';
    $icon = $icon ?? true;
    $dismissible = $dismissible ?? true;
    $important = $important ?? false;
@endphp

<div class="alert {{ $important ? 'alert-important' : '' }} alert-{{ $type }} {{ $dismissible ? 'alert-dismissible' : '' }} {{ $class ?? '' }}" role="alert">
    <div class="d-flex">
      @if ($icon)
        <div>
            @switch($type)
                @case('success')
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M5 12l5 5l10 -10"></path></svg>
                    @break
                @case('warning')
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M12 9v4"></path><path d="M10.363 3.591l-8.106 13.534a1.914 1.914 0 0 0 1.636 2.871h16.214a1.914 1.914 0 0 0 1.636 -2.87l-8.106 -13.536a1.914 1.914 0 0 0 -3.274 0z"></path><path d="M12 16h.01"></path></svg>
                    @break
                @case('danger')
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0"></path><path d="M12 8v4"></path><path d="M12 16h.01"></path></svg>
                    @break
                @default
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0"></path><path d="M12 9h.01"></path><path d="M11 12h1v4h1"></path></svg>
            @endswitch
        </div>
      @endif
      <div>
        @if (isset($title))
            <h4 class="alert-title {{ $important ? 'text-white' : '' }}">{{ $title }}</h4>
        @endif
        @if (isset($text))
            <div class="text-secondary">{!! $text !!}</div>
        @endif

        {{ $slot }}
      </div>
    </div>

    @if ($dismissible)
        <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
    @endif
</div>
```

## Layout Components

### App Layout

The app layout (`resources/views/components/layouts/app.blade.php`) is used for authenticated pages.

**Usage:**

```blade
<x-layouts.app>
    <x-slot name="header">
        <div class="col">
            <h2 class="page-title">
              {{ __('Page Title') }}
            </h2>
        </div>
    </x-slot>

    <!-- Page content -->
</x-layouts.app>
```

**Slots:**

- `header`: The page header content
- Default slot: The main page content

### Guest Layout

The guest layout (`resources/views/components/layouts/guest.blade.php`) is used for unauthenticated pages like login and registration.

**Usage:**

```blade
<x-layouts.guest>
    <!-- Page content -->
</x-layouts.guest>
```

**Slots:**

- Default slot: The main page content

## Livewire Components

Livewire components provide interactive functionality with minimal JavaScript. They are organized by type in the `app/Livewire/` directory.

### Form Components

#### Authentication Forms

- `LoginForm`: Handles user login
- `RegisterForm`: Handles user registration
- `ForgotPasswordForm`: Handles password reset requests
- `ResetPasswordForm`: Handles password reset
- `VerifyEmailForm`: Handles email verification
- `ConfirmPasswordForm`: Handles password confirmation

#### Account Forms

- `AccountInformationForm`: Handles profile information updates
- `AccountChangePasswordForm`: Handles password changes
- `AccountDeleteForm`: Handles account deletion

### Page Components

- `DashboardPage`: Renders the dashboard
- `UserListPage`: Renders the user list

## Creating Custom Components

### Creating a Custom Blade Component

1. Create a new Blade file in `resources/views/components/`:

```blade
{{-- resources/views/components/card.blade.php --}}
@props(['title' => null, 'footer' => null])

<div {{ $attributes->merge(['class' => 'card']) }}>
    @if ($title)
        <div class="card-header">
            <h3 class="card-title">{{ $title }}</h3>
        </div>
    @endif

    <div class="card-body">
        {{ $slot }}
    </div>

    @if ($footer)
        <div class="card-footer">
            {{ $footer }}
        </div>
    @endif
</div>
```

2. Use the component in your views:

```blade
<x-card title="Card Title" class="mb-3">
    Card content goes here

    <x-slot name="footer">
        Card footer content
    </x-slot>
</x-card>
```

### Creating a Custom Livewire Component

1. Create a new Livewire component:

```bash
php artisan make:livewire Components/DataTable
```

2. Implement the component class:

```php
<?php

namespace App\Livewire\Components;

use Livewire\Component;
use Livewire\WithPagination;

class DataTable extends Component
{
    use WithPagination;

    public $model;
    public $columns = [];
    public $searchColumn = 'name';
    public $searchTerm = '';

    public function mount($model, $columns, $searchColumn = 'name')
    {
        $this->model = $model;
        $this->columns = $columns;
        $this->searchColumn = $searchColumn;
    }

    public function render()
    {
        $modelClass = "App\\Models\\{$this->model}";
        $query = $modelClass::query();

        if ($this->searchTerm) {
            $query->where($this->searchColumn, 'like', "%{$this->searchTerm}%");
        }

        $data = $query->paginate(10);

        return view('livewire.components.data-table', [
            'data' => $data,
        ]);
    }
}
```

3. Create the view:

```blade
<div>
    <div class="mb-3">
        <input type="text" class="form-control" placeholder="Search..." wire:model.live="searchTerm">
    </div>

    <div class="table-responsive">
        <table class="table table-vcenter card-table">
            <thead>
                <tr>
                    @foreach($columns as $column)
                        <th>{{ ucfirst($column) }}</th>
                    @endforeach
                    <th class="w-1"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $item)
                    <tr wire:key="{{ $item->id }}">
                        @foreach($columns as $column)
                            <td>{{ $item->{$column} }}</td>
                        @endforeach
                        <td>
                            <div class="btn-list flex-nowrap">
                                <button class="btn btn-sm btn-primary" wire:click="edit({{ $item->id }})">Edit</button>
                                <button class="btn btn-sm btn-danger" wire:click="delete({{ $item->id }})">Delete</button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-3">
        {{ $data->links() }}
    </div>
</div>
```

4. Use the component:

```blade
<livewire:components.data-table
    model="User"
    :columns="['name', 'email', 'created_at']"
    searchColumn="email"
/>
```

## Best Practices for Components

1. **Keep components focused**: Each component should have a single responsibility.
2. **Make components reusable**: Design components to be reusable across different parts of your application.
3. **Use props for customization**: Allow components to be customized through props rather than hardcoding values.
4. **Document your components**: Add comments or documentation to explain how to use your components.
5. **Follow naming conventions**: Use consistent naming for your components.
6. **Use slots for flexible content**: Use slots to allow for flexible content within your components.
7. **Handle errors gracefully**: Ensure your components handle errors and edge cases.
8. **Test your components**: Write tests for your components to ensure they work as expected.

## Extending Tabler Components

Tabler provides many UI components that you can use in your application. Here are some examples:

### Buttons

```blade
<button class="btn btn-primary">Primary</button>
<button class="btn btn-secondary">Secondary</button>
<button class="btn btn-success">Success</button>
<button class="btn btn-warning">Warning</button>
<button class="btn btn-danger">Danger</button>
<button class="btn btn-link">Link</button>
```

### Cards

```blade
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Card Title</h3>
    </div>
    <div class="card-body">
        Card content
    </div>
    <div class="card-footer">
        Card footer
    </div>
</div>
```

### Modals

```blade
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
    Launch modal
</button>

<div class="modal modal-blur fade" id="exampleModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modal title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Modal content
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-link link-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary ms-auto">Save changes</button>
            </div>
        </div>
    </div>
</div>
```

For more Tabler components, refer to the [Tabler documentation](https://tabler.io/docs).

Remember, you can create Blade components for any of these Tabler UI elements to make them more reusable and easier to work with in your application.
