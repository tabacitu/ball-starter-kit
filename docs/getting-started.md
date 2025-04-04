# Getting Started

This document will help you get started with your new BALL stack application. The BALL stack consists of:

- **B**ootstrap (through the excellent Tabler HTML template)
- **A**s-little-js-as-possible
- **L**aravel
- **L**ivewire

## Installation

1. Clone the repository or download it as a ZIP file
2. Navigate to the project directory
3. Run `composer install`
4. Copy `.env.example` to `.env` and configure your database settings
5. Run `php artisan key:generate`
6. Run `php artisan migrate`
7. Start the development server with `php artisan serve`

## Initial Configuration

### Environment Variables

The most important environment variables to configure are:

- `APP_NAME` - The name of your application
- `APP_URL` - The URL of your application
- `DB_*` - Database connection details
- `MAIL_*` - Mail configuration (required for password reset and email verification)

### Mail Configuration

For features like password reset and email verification to work, you need to configure mail settings in your `.env` file:

```
MAIL_MAILER=smtp
MAIL_HOST=your-smtp-host
MAIL_PORT=587
MAIL_USERNAME=your-username
MAIL_PASSWORD=your-password
MAIL_SCHEME=tls
MAIL_FROM_ADDRESS=your-email@example.com
MAIL_FROM_NAME="${APP_NAME}"
```

For development, you can use services like [Mailtrap](https://mailtrap.io/) or [MailHog](https://github.com/mailhog/MailHog).

## First Steps After Installation

1. **Customize the application name and branding**
   - Update the `APP_NAME` in your `.env` file
   - Customize the logo and branding in the layouts

2. **Review the authentication system**
   - Test the registration, login, password reset, and email verification flows
   - Customize the authentication views if needed

3. **Explore the account settings**
   - Test the profile update, password change, and account deletion features
   - Customize the account settings views if needed

4. **Start building your application**
   - Add new routes in the appropriate route files
   - Create new Livewire components for your pages
   - Extend the User model if needed

## Making It Your Own

This starter kit is designed to be a foundation for your application. You should feel free to modify any part of it to suit your needs. Here are some common customizations:

1. **Modify the User model**
   - Add new fields to the users table
   - Add new relationships to other models
   - Add new methods for user-specific functionality

2. **Customize the authentication flow**
   - Add additional fields to the registration form
   - Implement additional verification steps
   - Add social authentication

3. **Extend the account settings**
   - Add new sections for user preferences
   - Add profile picture upload
   - Add additional security features

Remember, once you start using this starter kit, all the code becomes yours to modify and extend as needed.
