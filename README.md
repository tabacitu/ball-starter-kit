<h1 align="center"><a href="https://laravel.com" target="_blank">Backpack App Starter</a></h1>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

// TODO: screenshot or GIF here

## About 

This project is an application starter kit that uses the BALL stack (Bootstrap, Any-javascript-library-you-want, Laravel, Livewire). It's an alternative to Laravel Breeze and Laravel Jetstream. It provides the same features they do (auth, profile management, etc) with a simpler tech stack, fewer dependencies and better code organization (arguably).

Key differences from Laravel Breeze & Laravel Jetstream: 
- ✅ uses Bootstrap 5 instead of Tailwind CSS;
- ✅ does not use NPM, Webpack, Mix, etc - you can use any JS library you want, or none at all;
- ✅ has a clean, modern, generic design and 300+ HTML components thanks to the [Tabler HTML template](https://tabler.io/preview);
- 🚧 has all the features of Laravel Jetstream, with the simplicity of Laravel Breeze;
- ✅ provides blade components for forms, tables, modals, etc;
- 🚧 has a simple, clean, organized codebase, with a lot of comments and explanations;
- 🚧 has clear docs on how to build on top of it;

Key differences from Backpack/CRUD:
- Backpack is a library (a Composer package), AppStarter is Laravel installation (for now).
- Backpack is for building admin panels, AppStarter is for building custom applications.
- Backpack is meant to be used in existing projects, AppStarter is meant to be used as a starting point for new projects.
- Backpack has a lot of features, AppStarter only has the features you'd expect in all new projects (auth, profile management, etc).
- Backpack has a lot of dependencies, AppStarter has very few.
- Backpack is easier to customize than any other admin panel, but AppStarter is even easier to customize - every file is 100% in your control and you can do whatever you want to it.
- AppStarter is not an alternative to [Backpack/CRUD](https://github.com/laravel-backpack/crud) - you can use both in the same project. Use AppStarter to create your customer-facing application (that will probably end up super custom), and Backpack/CRUD to create your admin panel (that will probably end up with a lot of the same features as other admin panels).

# Usage

1. Clone the repository `git clone https://github.com/Laravel-Backpack/app-starter.git your-project-name`
2. Go inside the project folder `cd your-project-name`.
3. Run `composer install`.
4. Customize the `.env` file with your database credentials and other settings.
5. Run `php artisan migrate`.
5. Done - go see it in your browser. Use `php artisan serve` or whatever you prefer.

# Testing

The package already provides a few tests, for the features it provides. You can run them with `phpunit` or `vendor/bin/phpunit`.

# Contributing

If you want to contribute, please read the [CONTRIBUTING.md](CONTRIBUTING.md) file first. We have a limited scope for this project, so if it's a feature, please open an issue and asking, before spending a lot of time creating a PR.

## Security Vulnerabilities

If you discover a security vulnerability, please send an e-mail to Cristian Tabacitu via [cristian.tabacitu@backpackforlaravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

AppStarter is open-source software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## FAQ

### Why an App Starter Kit from Backpack?

When you think "_[Backpack for Laravel](https://backpackforlaravel.com)_" you think "_admin panel_". That's 100% true, that's what our main product [Backpack/CRUD](https://github.com/laravel-backpack/crud) and all its add-ons will do for you. **This package is different. Its goal is NOT to help you build an admin panel.** Its goal is to help you build an application (most likely a SaaS), as fast as possible. It brings in the simple tech stack we love in Backpack/CRUD and all the wisdom we've gathered in the last 15 years building applications for clients, and it's meant to be a starting point for your new Laravel application. You can use it as a boilerplate for your new projects, and build on top of it. It's a solid foundation, with a lot of the boilerplate code you'd normally have to write, already written for you. We've made a lot of choices in terms of tech stack, code organization, design patterns and dependencies, so you don't have to. Instead of trying to make sense of the countless options out there, you can just start building your app. If you liked the Backpack way of doing things, you'll love this app starter kit.

**Why build you app using AppStarter instead of Backpack?** In one word - complete control over the files. All admin panels have the pretty much the same features, so it makes most sense to use a library like Backpack, where we maintain the features and add more. Application on the other hand can be _completely_ different, and need a level of customization that can only be achieved one way sustainably - having those files in your project, to do whatever the f*$k you want with them. That's what AppStarter provides, and when you should use it instead of Backpack. When you want complete control.
