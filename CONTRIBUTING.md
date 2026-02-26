# Contributing to SwiftRoute

Thank you for your interest in contributing to SwiftRoute! This document provides guidelines and steps for contributing.

## Code of Conduct

Please be respectful and constructive in all interactions. We are committed to providing a welcoming and inclusive environment for everyone.

## How to Contribute

### Reporting Bugs

1. Check existing [issues](../../issues) to avoid duplicates
2. Use the bug report template
3. Include steps to reproduce, expected vs actual behavior
4. Include Laravel/PHP versions and relevant logs

### Suggesting Features

1. Open an issue with the feature request template
2. Describe the use case and expected behavior
3. Consider if it fits the project scope

### Pull Requests

1. **Fork** the repository
2. **Clone** your fork locally
3. **Create a branch** from `main`:
   ```bash
   git checkout -b feature/your-feature-name
   ```
4. **Make changes** following our coding standards
5. **Write/update tests** for your changes
6. **Run the test suite**:
   ```bash
   make test
   ```
7. **Check code style**:
   ```bash
   make lint
   ```
8. **Commit** with a clear message:
   ```bash
   git commit -m "feat: add new pricing calculator option"
   ```
9. **Push** to your fork
10. **Open a Pull Request** against `main`

## Development Setup

```bash
# Clone your fork
git clone https://github.com/dhtml/swiftroute.git
cd swiftroute

# Start development environment
make install

# Run tests
make test

# Check code style
make lint
```

## Coding Standards

- Follow [PSR-12](https://www.php-fig.org/psr/psr-12/) coding style
- Use [Laravel Pint](https://laravel.com/docs/pint) for formatting
- Write meaningful commit messages following [Conventional Commits](https://www.conventionalcommits.org/)
- Add PHPDoc blocks for public methods
- Keep methods focused and under 20 lines when possible

## Commit Message Format

```
type(scope): description

[optional body]
```

Types: `feat`, `fix`, `docs`, `style`, `refactor`, `test`, `chore`

Examples:
- `feat(pricing): add surge pricing support`
- `fix(booking): correct time slot validation`
- `docs: update API documentation`

## Testing

- Write tests for new features
- Ensure existing tests pass
- Aim for meaningful test coverage
- Use factories for test data

```bash
# Run all tests
make test

# Run specific test
docker compose exec app php artisan test --filter=PricingTest
```

## Questions?

Open an issue with the "question" label or start a discussion.

Thank you for contributing!
