# Contributing to Learning Progress Tracker

Thank you for your interest in contributing to the Learning Progress Tracker! This document provides guidelines and instructions for contributing to this project.

---

## Table of Contents

1. [Code of Conduct](#code-of-conduct)
2. [Getting Started](#getting-started)
3. [Development Workflow](#development-workflow)
4. [Coding Standards](#coding-standards)
5. [Commit Message Guidelines](#commit-message-guidelines)
6. [Pull Request Process](#pull-request-process)
7. [Testing Guidelines](#testing-guidelines)
8. [Documentation](#documentation)

---

## Code of Conduct

### Our Pledge

We are committed to providing a welcoming and inspiring community for all. Please be respectful and constructive in your interactions.

### Expected Behavior

- Use welcoming and inclusive language
- Be respectful of differing viewpoints
- Accept constructive criticism gracefully
- Focus on what is best for the community
- Show empathy towards other community members

---

## Getting Started

### Prerequisites

- PHP 8.2+
- Composer
- Node.js 18+
- MySQL 8.0+
- Git

### Setup Development Environment

1. **Fork the repository**
   ```bash
   # Click "Fork" button on GitHub
   ```

2. **Clone your fork**
   ```bash
   git clone git@github.com:YOUR_USERNAME/learning_tracker.git
   cd learning_tracker
   ```

3. **Add upstream remote**
   ```bash
   git remote add upstream git@github.com:Abrar1968/learning_tracker.git
   ```

4. **Install dependencies**
   ```bash
   composer install
   npm install
   ```

5. **Setup environment**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

6. **Configure database**
   ```bash
   # Create database and update .env
   php artisan migrate
   php artisan db:seed
   ```

7. **Build assets**
   ```bash
   npm run dev
   ```

8. **Start server**
   ```bash
   php artisan serve
   ```

---

## Development Workflow

### Branch Strategy

We follow a Git Flow branching strategy:

- `main` - Production-ready code
- `develop` - Development branch
- `feature/*` - New features
- `fix/*` - Bug fixes
- `hotfix/*` - Critical production fixes
- `release/*` - Release preparation

### Creating a New Feature

1. **Update your local repository**
   ```bash
   git checkout develop
   git pull upstream develop
   ```

2. **Create a feature branch**
   ```bash
   git checkout -b feature/your-feature-name
   ```

3. **Make your changes**
   - Write clean, documented code
   - Follow coding standards
   - Add tests for new functionality

4. **Commit your changes**
   ```bash
   git add .
   git commit -m "feat: add your feature description"
   ```

5. **Push to your fork**
   ```bash
   git push origin feature/your-feature-name
   ```

6. **Create Pull Request**
   - Go to GitHub
   - Click "New Pull Request"
   - Select `develop` as base branch
   - Fill out the PR template

---

## Coding Standards

### PHP Standards

We follow **PSR-12** coding standards.

#### Formatting

```php
<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class ExampleService
{
    public function __construct(
        private UserRepository $userRepository
    ) {}

    public function processData(array $data): User
    {
        return DB::transaction(function () use ($data) {
            // Implementation
            return $this->userRepository->create($data);
        });
    }
}
```

#### Key Rules

- Use 4 spaces for indentation (not tabs)
- Opening braces on same line for methods
- Type hints for all parameters and return types
- One class per file
- Use strict types: `declare(strict_types=1);`

#### Run PHP CS Fixer

```bash
# Check code style
./vendor/bin/pint --test

# Fix code style
./vendor/bin/pint
```

### JavaScript Standards

- Use ESLint configuration
- Prefer `const` over `let`
- Use arrow functions when appropriate
- Comment complex logic

```javascript
// Good
const calculateProgress = (completed, total) => {
    return (completed / total) * 100;
};

// Bad
function calculateProgress(completed, total) {
    var progress = completed / total * 100;
    return progress;
}
```

### Blade Templates

- Use 4 spaces for indentation
- Keep logic minimal in views
- Extract reusable components
- Use `@` directives consistently

```blade
{{-- Good --}}
<x-card>
    <h2 class="text-xl font-semibold">{{ $roadmap->title }}</h2>
    
    @if($roadmap->description)
        <p class="text-gray-600">{{ $roadmap->description }}</p>
    @endif
</x-card>

{{-- Bad --}}
<div class="card">
<h2>{{ $roadmap->title }}</h2>
<?php if($roadmap->description): ?>
<p>{{ $roadmap->description }}</p>
<?php endif; ?>
</div>
```

### CSS/Tailwind

- Use Tailwind utility classes
- Avoid custom CSS when possible
- Extract components with @apply sparingly
- Follow mobile-first approach

```html
<!-- Good -->
<button class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors">
    Click Me
</button>

<!-- Avoid -->
<button class="custom-button">
    Click Me
</button>

<style>
.custom-button {
    /* custom styles */
}
</style>
```

---

## Commit Message Guidelines

### Format

```
<type>(<scope>): <subject>

<body>

<footer>
```

### Types

- **feat**: New feature
- **fix**: Bug fix
- **docs**: Documentation changes
- **style**: Code style changes (formatting, no logic change)
- **refactor**: Code refactoring
- **test**: Adding or updating tests
- **chore**: Maintenance tasks

### Examples

```bash
# Simple feature
git commit -m "feat: add roadmap filtering by category"

# Bug fix with scope
git commit -m "fix(auth): resolve password reset email issue"

# Breaking change
git commit -m "feat!: change API response format

BREAKING CHANGE: API now returns data in camelCase instead of snake_case"

# Multiple changes
git commit -m "refactor: improve progress calculation service

- Extract score calculation to separate method
- Add caching for frequently accessed data
- Improve query performance with eager loading"
```

### Rules

1. Use imperative mood ("add" not "added")
2. Don't capitalize first letter
3. No period at the end
4. Limit subject line to 50 characters
5. Wrap body at 72 characters
6. Reference issues in footer

---

## Pull Request Process

### Before Submitting

1. **Update your branch**
   ```bash
   git checkout develop
   git pull upstream develop
   git checkout your-feature-branch
   git rebase develop
   ```

2. **Run tests**
   ```bash
   php artisan test
   ```

3. **Check code style**
   ```bash
   ./vendor/bin/pint --test
   ```

4. **Build assets**
   ```bash
   npm run build
   ```

### PR Template

When creating a PR, please use this template:

```markdown
## Description
Brief description of changes

## Type of Change
- [ ] Bug fix
- [ ] New feature
- [ ] Breaking change
- [ ] Documentation update

## Related Issue
Closes #123

## Changes Made
- Change 1
- Change 2

## Testing
- [ ] Unit tests added/updated
- [ ] Feature tests added/updated
- [ ] Manual testing completed

## Screenshots (if applicable)
[Add screenshots here]

## Checklist
- [ ] Code follows project style guidelines
- [ ] Self-review completed
- [ ] Comments added for complex code
- [ ] Documentation updated
- [ ] No new warnings generated
- [ ] Tests pass locally
```

### Review Process

1. Automated checks must pass (tests, linting)
2. At least one approval required
3. No unresolved conversations
4. Up-to-date with base branch

### After Approval

```bash
# Squash commits if needed
git rebase -i develop

# Force push if rebased
git push --force-with-lease origin your-feature-branch
```

---

## Testing Guidelines

### Test Structure

```php
<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoadmapTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_roadmap(): void
    {
        // Arrange
        $user = User::factory()->create();

        // Act
        $response = $this->actingAs($user)->post('/roadmaps', [
            'title' => 'Test Roadmap',
            'description' => 'Test description',
        ]);

        // Assert
        $response->assertStatus(201);
        $this->assertDatabaseHas('roadmaps', [
            'title' => 'Test Roadmap',
            'user_id' => $user->id,
        ]);
    }
}
```

### Testing Rules

1. **Use factories** for test data
2. **Test one thing** per test method
3. **Use descriptive names** following `test_subject_scenario_expectedBehavior`
4. **Arrange-Act-Assert** pattern
5. **Clean up** after tests (RefreshDatabase trait)

### Running Tests

```bash
# All tests
php artisan test

# Specific test file
php artisan test tests/Feature/RoadmapTest.php

# Specific test method
php artisan test --filter test_user_can_create_roadmap

# With coverage
php artisan test --coverage

# Parallel execution
php artisan test --parallel
```

---

## Documentation

### Code Documentation

#### PHP Docblocks

```php
/**
 * Calculate roadmap progress percentage
 *
 * @param Roadmap $roadmap The roadmap to calculate progress for
 * @return float Progress percentage (0-100)
 * @throws \Exception If roadmap has no topics
 */
public function calculateProgress(Roadmap $roadmap): float
{
    // Implementation
}
```

#### Complex Logic

```php
// Calculate weighted score based on topic completion
// Each topic contributes to the overall score based on its weight
// Formula: (sum of completed topic weights / sum of all topic weights) * 100
$score = ($completedWeight / $totalWeight) * 100;
```

### Markdown Documentation

- Use clear headings
- Include code examples
- Add table of contents for long documents
- Keep line length under 120 characters
- Use proper markdown formatting

---

## Questions?

If you have questions:

1. Check existing issues on GitHub
2. Search the documentation
3. Ask in discussions
4. Create a new issue with `question` label

---

## License

By contributing, you agree that your contributions will be licensed under the project's license.

---

Thank you for contributing to Learning Progress Tracker! 🎉
