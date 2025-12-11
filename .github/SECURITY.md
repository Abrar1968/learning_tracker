# Security Policy

## Supported Versions

We release patches for security vulnerabilities in the following versions:

| Version | Supported          |
| ------- | ------------------ |
| 1.x.x   | :white_check_mark: |
| < 1.0   | :x:                |

## Reporting a Vulnerability

The Learning Progress Tracker team takes security seriously. We appreciate your efforts to responsibly disclose your findings.

### How to Report

**DO NOT** create a public GitHub issue for security vulnerabilities.

Instead, please report security vulnerabilities by emailing:

📧 **security@your-domain.com**

### What to Include

Please include the following information in your report:

1. **Description**: A clear description of the vulnerability
2. **Impact**: The potential impact and severity
3. **Steps to Reproduce**: Detailed steps to reproduce the issue
4. **Proof of Concept**: Code or screenshots demonstrating the vulnerability
5. **Affected Versions**: Which versions are affected
6. **Suggested Fix**: If you have any suggestions for fixing the issue

### Example Report

```
Subject: [Security] SQL Injection in Roadmap Search

Description:
The roadmap search functionality is vulnerable to SQL injection attacks.

Impact:
An attacker could execute arbitrary SQL queries, potentially accessing 
or modifying sensitive data in the database.

Steps to Reproduce:
1. Navigate to /roadmaps/search
2. Enter the following in the search field: ' OR '1'='1
3. Submit the form
4. Observe unauthorized data access

Affected Versions:
1.0.0 - 1.2.5

Suggested Fix:
Use parameterized queries or Laravel's query builder instead of raw SQL.
```

### Response Timeline

- **Initial Response**: Within 48 hours
- **Status Update**: Within 7 days
- **Resolution Timeline**: Depends on severity
  - Critical: 1-7 days
  - High: 7-30 days
  - Medium: 30-90 days
  - Low: 90+ days

### What to Expect

1. **Acknowledgment**: We'll acknowledge receipt of your report
2. **Investigation**: We'll investigate and validate the vulnerability
3. **Fix Development**: We'll develop and test a fix
4. **Disclosure**: We'll coordinate disclosure with you
5. **Credit**: We'll credit you for the discovery (if desired)

## Security Best Practices

### For Users

1. **Keep Updated**: Always use the latest version
2. **Secure Configuration**: Follow the security checklist in docs
3. **Strong Passwords**: Use strong, unique passwords
4. **HTTPS**: Always use HTTPS in production
5. **Environment Variables**: Never commit `.env` files

### For Developers

1. **Input Validation**: Validate all user input
2. **SQL Injection**: Use parameterized queries
3. **XSS Prevention**: Escape output properly
4. **CSRF Protection**: Use Laravel's CSRF tokens
5. **Authentication**: Use Laravel's built-in auth
6. **Authorization**: Implement proper policies
7. **Dependencies**: Keep dependencies updated

## Known Security Considerations

### Authentication

- Laravel Breeze is used for authentication
- Passwords are hashed using bcrypt
- Session tokens are securely generated
- Password reset uses secure tokens

### Authorization

- Policies are implemented for all resources
- Users can only access their own data
- Admin roles are properly validated

### Database Security

- All queries use Eloquent ORM or Query Builder
- No raw SQL queries without parameter binding
- Database credentials stored in environment variables

### File Upload Security

- File types are validated
- File sizes are limited
- Files are stored outside public directory
- Filenames are sanitized

### API Security

- Rate limiting is implemented
- API tokens are securely generated
- CORS is properly configured

## Security Checklist for Production

Before deploying to production, ensure:

- [ ] `APP_DEBUG=false` in production
- [ ] `APP_ENV=production` is set
- [ ] Database credentials are secure
- [ ] HTTPS is enabled
- [ ] CSRF protection is enabled
- [ ] File permissions are correct (755 for directories, 644 for files)
- [ ] Storage directory is not publicly accessible
- [ ] `.env` file is not in version control
- [ ] Security headers are configured
- [ ] Error reporting is disabled for users
- [ ] Logs are monitored
- [ ] Regular backups are configured
- [ ] Dependencies are up to date
- [ ] `composer audit` passes
- [ ] `npm audit` passes

## Security Updates

Security updates will be announced via:

1. GitHub Security Advisories
2. Release notes
3. Email notifications (if subscribed)

## Vulnerability Disclosure Policy

We follow a coordinated disclosure model:

1. **Private Disclosure**: Report sent privately to security team
2. **Investigation**: Team investigates and develops fix
3. **Fix Released**: Security patch is released
4. **Public Disclosure**: Vulnerability is publicly disclosed after fix

We aim to disclose vulnerabilities within 90 days of the initial report.

## Hall of Fame

We recognize security researchers who help us:

<!-- Security researchers will be listed here -->

_No security issues reported yet._

## Contact

For security concerns:
- 📧 Email: security@your-domain.com
- 🔒 PGP Key: Available upon request

For general questions:
- 💬 Discussions: https://github.com/Abrar1968/learning_tracker/discussions
- 🐛 Issues: https://github.com/Abrar1968/learning_tracker/issues

---

Thank you for helping keep Learning Progress Tracker secure! 🔒
