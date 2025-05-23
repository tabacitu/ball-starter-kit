<h1 align="center"><a href="https://github.com/tabacitu/ball-starter-kit" target="_blank">BALL Starter Kit</a></h1>

<p align="center">
<a href="https://packagist.org/packages/tabacitu/ball-starter-kit"><img src="https://img.shields.io/packagist/v/tabacitu/ball-starter-kit" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/tabacitu/ball-starter-kit"><img src="https://img.shields.io/packagist/dt/tabacitu/ball-starter-kit" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/tabacitu/ball-starter-kit"><img src="https://img.shields.io/packagist/l/tabacitu/ball-starter-kit" alt="License"></a>
</p>

![ezgif com-animated-gif-maker](https://github.com/user-attachments/assets/0a82d0da-a9d5-49cc-a09e-57bace3e209f)

See [all screenshots](https://github.com/tabacitu/ball-starter-kit/issues/5).

# About

This project is an application starter kit. It's an alternative to Laravel Breeze and Laravel Jetstream that uses the BALL stack (Bootstrap, Any-javascript-library-you-want, Laravel, Livewire).  It provides the same features they do (auth, profile management, etc) with a simpler tech stack, fewer dependencies and better code organization (arguably).

Key differences from Laravel Breeze & Laravel Jetstream:
- ✅ uses Bootstrap 5 instead of Tailwind CSS;
- ✅ has a clean, modern, generic design and 300+ HTML components thanks to the [Tabler HTML template](https://tabler.io/preview);
- ✅ does not use NPM, Webpack, Mix, etc - you can use any JS library you want, or none at all; you can even use assets straight from the CDN (both in development and production), and Basset will download and serve them from the same server;
- ✅ has a simple, organized codebase, with a lot of comments and explanations;
- ✅ has clear docs on how to build on top of it;
- ✅ has a full test suite, that you can add to;

It's something that we've built to scratch our own itch, because we need to create many new Laravel SaaS projects from scratch. We've made it public because there's nothing online that fixes the problem in a way we like, and we believe this can help other people save a lot of time and headache. If you use and like this project, please [open an issue](https://github.com/tabacitu/ball-starter-kit/issues) and tell us about it, the good and the bad - we love to know we helped.

## Roadmap

If you'd like to see any of these features implemented in future versions, please open an issue:

- Example marketing pages
- Team/organization support

## Documentation

Comprehensive documentation is available in the `/docs` directory:

- [Getting Started](docs/getting-started.md) - Installation, configuration, and first steps
- [Architecture](docs/architecture.md) - BALL stack, directory structure, and design patterns
- [Features](docs/features.md) - Authentication, account settings, and other built-in features
- [Customization](docs/customization.md) - How to extend the application with new pages and functionality
- [Components](docs/components.md) - Reusable components and how to use them
- [Testing](docs/tests.md) - Test suite structure, tools, and best practices

These documents are designed to become your own project documentation once you start using this starter kit.

### Asset Management

The starter kit loads Tabler CSS and JS files from CDNs for development convenience, but uses [Basset](https://github.com/blade-ui-kit/basset) to internalize these assets for production. This approach:

- Provides the convenience of working with CDNs during development
- Protects your application from privacy/GDPR issues in production
- Ensures your application works even if the CDNs are down
- Improves load times by serving assets from your own server

To use Basset for your own assets, see the [Basset documentation](https://github.com/blade-ui-kit/basset).

# Installation

You can install the BALL Starter Kit in one of three ways:

## Option 1: Using the Laravel Installer (Recommended)

```bash
laravel new --using tabacitu/ball-starter-kit your-app-name
```

## Option 2: Using Composer Create-Project

```bash
composer create-project tabacitu/ball-starter-kit your-app-name
```

## Option 3: Cloning the Repository

```bash
git clone https://github.com/tabacitu/ball-starter-kit.git your-app-name
cd your-app-name
composer install
```

After installation, regardless of the method used:

1. Configure your `.env` file with your database credentials and other settings
2. Run `php artisan key:generate` (if not already done by the installer)
3. Run `php artisan migrate`
4. Start the development server with `php artisan serve`

## FAQ

<details>
  <summary><strong>What is the BALL Stack?</strong></summary>

The BALL stack is a series of tech choices that we prefer to make, when building Laravel projects. The acronym comes from Bootstrap, Any-javascript-library, Laravel and Livewire. When compared with other popular stacks like VILT and TALL, it's more similar to the TALL stack, with a few differences:
- it uses good-old-fashioned Bootstrap instead of Tailwind;
- it doesn't use NPM, bundling, compiling etc; instead it just loads the CSS & JS using simple `<link>` and `<script>` tags (the way the web was designed to work);
- it tries to use as little JavaScript as possible (but since Alpine is baked into Livewire, we usually reach for that);

The choices in the BALL stack are a result of _intentional tech minimalism_. After 15+ years of building web apps, we have found that the best thing you can do for most projects is to [use boring technologies](https://boringtechnology.club/), keep dependencies to a minimum and stick to tried-and-true web practices. That results in fast, fun and maintainable web development. The BALL stack is a response to the "_shiny object syndrome_" that plagues modern web development, where everything changes every few months or years, with very little use to most web dev projects themselves. Key benefits of the BALL Stack:
- Because HTML, Bootstrap, CSS and PHP will not change much, it's **a stack that will not change much**.
- Because you're using tools that you already know, **you'll save a lot of time during development**,
- Because the tech is easy to learn, **any developer will be easy to onboard onto the project** (from junior to senior).
- Because the tech doesn't change much, **the project will be easy to extend and maintain 5 years from now**.
- Because it avoids the JavaScript ecosystem, you are **avoiding the most toxic part of web development**.

</details>

<details>
  <summary><strong>What tech do you recommend using for each part of the project?</strong></summary>

The "_best tool for the job_" depends from project to project. And tech choices are subject to personal opinion. We found in 90% of all projects, it's best to keep things simple, and have a minimal stack, so we reach for the following tools:
- marketing website - buy a design - either a Premium HTML Template or a WordPress, Webflow template etc;
- application - Bootstrap, Laravel, Livewire - hence this app starter kit;
- admin panel - Backpack for Laravel;

</details>

<details>
  <summary><strong>Why an application starter kit from the guy who made Backpack?</strong></summary>

When you think "_[Backpack for Laravel](https://backpackforlaravel.com)_" you think "_admin panel_". That's 100% true, that's what our main product [Backpack/CRUD](https://github.com/laravel-backpack/crud) and all its add-ons will do for you. **This package is different. Its goal is NOT to help you build an admin panel. Its goal is to help you build an application** (most likely a SaaS), as fast as possible, from scratch (pun intended).

We strongly believe in most projects it's best to:
- code from scratch the part where **the end-user** logs in and does stuff;
- use Backpack, Filament or Nova for the part where **the administrator** logs in and does stuff;

The BALL Starter Kit doesn't fix the "administrator" problem, it fixes the "end-user" problem. It brings in the simple tech stack we love and all the wisdom we've gained in the last 15 years building applications. You can use it as a boilerplate for your new projects, and build on top of it. It's a solid foundation, with a lot of the boilerplate code you'd normally have to write, already written for you. We've made a lot of choices in terms of tech stack, code organization, design patterns and dependencies, so you don't have to. Instead of trying to make sense of the countless options out there, you can just start building your app. If you liked the simple Backpack way of doing things, you'll love this app starter kit.

</details>

<details>
  <summary><strong>Why build you client-facing app using BALL Starter Kit instead of Backpack?</strong></summary>

In one word - complete control over the files. All admin panels have the pretty much the same features, so it makes most sense to use a library like Backpack, where we maintain the features and add more. Application on the other hand can be _completely_ different. They need a level of customization that can only be achieved sustainably one way - having those files in your project, to do whatever the f*$k you want with them. That's what BALL Starter Kit provides, and when you should use it instead of Backpack. When you want complete control.

Key differences from Backpack/CRUD:
- Backpack is a library (a Composer package), BALL Starter Kit is Laravel installation (for now).
- Backpack is for building admin panels, BALL Starter Kit is for building custom applications.
- Backpack is meant to be used in existing projects, BALL Starter Kit is meant to be used as a starting point for new projects.
- Backpack has a lot of features, BALL Starter Kit only has the features you'd expect in all new projects (auth, profile management, etc).
- Backpack has a lot of dependencies, BALL Starter Kit has very few.
- Backpack is easier to customize than any other admin panel, but BALL Starter Kit is even easier to customize - every file is 100% in your control and you can do whatever you want to it.
- BALL Starter Kit is not an alternative to [Backpack/CRUD](https://github.com/laravel-backpack/crud) - you can use both in the same project. Use BALL Starter Kit to create your customer-facing application (that will probably end up super custom), and Backpack/CRUD to create your admin panel (that will probably end up with a lot of the same features as other admin panels).

</details>

## Testing

The package already provides a comprehensive test suite for the features it includes. For detailed information about the test structure, tools, and best practices, see the [Testing documentation](docs/tests.md).

You can run the tests with:
```bash
php artisan test
```

Or using PHPUnit directly:
```bash
vendor/bin/phpunit
```

## Contributing

If you want to contribute, please read the [CONTRIBUTING.md](CONTRIBUTING.md) file first. We have a limited scope for this project, so if it's a feature, please open an issue and ask, before spending a lot of time creating a PR.

## Security Vulnerabilities

If you discover a security vulnerability, please send an e-mail to Cristian Tabacitu via [cristian.tabacitu@digitallyhappy.com](mailto:cristian.tabacitu@digitallyhappy.com). All security vulnerabilities will be promptly addressed.

## License

BALL Starter Kit is open-source software licensed under the [MIT license](https://opensource.org/licenses/MIT).
