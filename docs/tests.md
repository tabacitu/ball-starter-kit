# Testing

This document provides an overview of the test suite for your BALL stack application. It explains the testing structure, available tools, and best practices for extending the test suite with your own tests.

## Test Structure

The test suite is organized into the following categories:

### Unit Tests

Unit tests focus on testing individual components in isolation, such as services and models.

- `tests/Unit/Services/`: Tests for service classes
  - `AuthenticationServiceTest.php`: Tests for authentication-related services
  - `UserAccountServiceTest.php`: Tests for user account management services

### Feature Tests

Feature tests focus on testing complete features and user flows.

- `tests/Feature/Auth/`: Tests for authentication features
  - `RegistrationTest.php`: Tests for user registration
  - `LoginTest.php`: Tests for user login and logout
  - `PasswordResetTest.php`: Tests for password reset functionality
  - `EmailVerificationTest.php`: Tests for email verification
- `tests/Feature/Account/`: Tests for account management features
  - `AccountSettingsTest.php`: Tests for account settings page and functionality

### Livewire Component Tests

Livewire component tests focus on testing the interactive components.

- `tests/Feature/Livewire/Forms/Auth/`: Tests for authentication forms
  - `LoginFormTest.php`: Tests for the login form component
  - `RegisterFormTest.php`: Tests for the registration form component
- `tests/Feature/Livewire/Forms/Account/`: Tests for account management forms
  - `AccountInformationFormTest.php`: Tests for the account information form
  - `AccountChangePasswordFormTest.php`: Tests for the password change form
  - `AccountDeleteFormTest.php`: Tests for the account deletion form

## Test Base Classes

The test suite includes several helper classes:

- `TestCase.php`: Base test case with common functionality and database refreshing
- `UnitTestCase.php`: Base test case for unit tests with specific setup/teardown methods
- `FeatureTestCase.php`: Base test case for feature tests with authentication helpers

## Running Tests

To run the entire test suite:

```bash
php artisan test
```

This is the recommended Laravel way to run tests. Alternatively, you can use PHPUnit directly:

```bash
./vendor/bin/phpunit
```

To run a specific test category:

```bash
php artisan test --testsuite=Unit
php artisan test --testsuite=Feature
```

To run a specific test file:

```bash
php artisan test tests/Feature/Auth/LoginTest.php
```

To run a specific test method:

```bash
php artisan test --filter=test_users_can_authenticate_using_the_login_form
```

## Test Database

The tests use an in-memory SQLite database, which is configured in the `phpunit.xml` file. This ensures that tests run quickly and don't affect your development database.

## Testing Approaches

### Unit Testing

Unit tests focus on testing individual components in isolation. They typically:

- Test a single class or method
- Mock dependencies to isolate the component being tested
- Focus on input/output and behavior verification
- Run quickly and don't depend on external services

Example from `AuthenticationServiceTest.php`:

```php
#[Test]
public function it_validates_login_credentials()
{
    $credentials = [
        'email' => $this->faker->email,
        'password' => 'password',
    ];

    $validated = $this->authService->validateLoginCredentials($credentials);

    $this->assertEquals($credentials, $validated);
}
```

### Feature Testing

Feature tests focus on testing complete features and user flows. They typically:

- Test multiple components working together
- Test HTTP requests and responses
- Verify that the application behaves correctly from the user's perspective
- May interact with the database and other services

Example from `LoginTest.php`:

```php
#[Test]
public function users_can_authenticate_using_the_login_form()
{
    $user = User::factory()->create([
        'email' => 'test@example.com',
        'password' => Hash::make('password'),
    ]);

    Livewire::test('forms.auth.login-form')
        ->set('email', 'test@example.com')
        ->set('password', 'password')
        ->call('save')
        ->assertRedirect('/dashboard');

    $this->assertAuthenticated();
}
```

### Livewire Component Testing

Livewire component tests focus on testing interactive components. They typically:

- Test component rendering
- Test component state and properties
- Test component methods and events
- Verify that the component behaves correctly from the user's perspective

Example from `LoginFormTest.php`:

```php
#[Test]
public function login_form_validates_email()
{
    Livewire::test(LoginForm::class)
        ->set('email', 'not-an-email')
        ->set('password', 'password')
        ->call('save')
        ->assertHasErrors('email');

    $this->assertGuest();
}
```

## Mocking

Some tests use mocking to isolate the component being tested. For example, service classes are mocked in Livewire component tests to avoid testing the service implementation details.

Example from `AccountInformationFormTest.php`:

```php
#[Test]
public function account_information_form_can_send_verification_email()
{
    $user = User::factory()->create([
        'email_verified_at' => null,
    ]);

    // Mock the UserAccountService to verify sendVerificationEmail is called
    $userAccountServiceMock = $this->mock('App\Services\UserAccountService');
    $userAccountServiceMock->shouldReceive('sendVerificationEmail')
        ->once()
        ->withAnyArgs()
        ->andReturn(true);

    Livewire::actingAs($user)
        ->test(AccountInformationForm::class)
        ->call('sendVerificationEmail');
}
```

## Best Practices

When extending the test suite with your own tests, follow these guidelines:

1. **Organize tests logically**: Place tests in the appropriate directory based on what they're testing.
2. **Use descriptive test method names**: Name your tests to clearly describe what they're testing.
3. **Follow the AAA pattern**: Arrange, Act, Assert - set up the test, perform the action, verify the result.
4. **Test both success and failure cases**: Ensure your code handles both valid and invalid inputs.
5. **Keep tests focused**: Each test should verify a single aspect of behavior.
6. **Use factories for test data**: Use Laravel's model factories to create test data.
7. **Clean up after tests**: Ensure tests don't leave side effects that could affect other tests.
8. **Use appropriate assertions**: Use specific assertions that clearly communicate what you're testing.

## Extending the Test Suite

When adding new features to your application, follow these steps to extend the test suite:

1. **Identify what to test**: Determine which components, services, and user flows need testing.
2. **Choose the appropriate test type**: Decide whether to write unit, feature, or Livewire component tests.
3. **Create test classes**: Create new test classes in the appropriate directories.
4. **Write test methods**: Write test methods that cover both success and failure cases.
5. **Run the tests**: Run the tests to ensure they pass and provide the expected coverage.

### Example: Adding Tests for a New Feature

If you're adding a new feature, such as a subscription management system, you might:

1. Create unit tests for the subscription service in `tests/Unit/Services/SubscriptionServiceTest.php`
2. Create feature tests for subscription management in `tests/Feature/Subscription/SubscriptionManagementTest.php`
3. Create Livewire component tests for subscription forms in `tests/Feature/Livewire/Forms/Subscription/`

## Coverage

To generate a code coverage report:

```bash
php artisan test --coverage
```

For an HTML coverage report:

```bash
php artisan test --coverage-html=coverage
```

Then open `coverage/index.html` in your browser to view the report.

## Continuous Integration

Consider setting up continuous integration to run your tests automatically when you push changes to your repository. This helps catch issues early and ensures your application remains stable as it evolves.

Popular CI services include:

- GitHub Actions
- GitLab CI
- CircleCI
- Travis CI

## Conclusion

A comprehensive test suite is essential for maintaining a stable and reliable application. By following the patterns and practices outlined in this document, you can extend the test suite to cover your own features and ensure your application works as expected.

Remember that tests are not just about catching bugs—they're also documentation that shows how your code is supposed to work. Well-written tests make it easier for new developers to understand your codebase and contribute to your project.
