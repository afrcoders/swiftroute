# SwiftRoute Security Policy

## Supported Versions

| Version | Supported          |
| ------- | ------------------ |
| 1.x     | :white_check_mark: |

## Reporting a Vulnerability

If you discover a security vulnerability within SwiftRoute, please open a private security advisory at https://github.com/dhtml/swiftroute/security/advisories/new. All security vulnerabilities will be promptly addressed.

Please include the following information in your report:

- Type of issue (e.g., SQL injection, XSS, authentication bypass)
- Full paths of source file(s) related to the issue
- Location of the affected source code (tag/branch/commit or direct URL)
- Step-by-step instructions to reproduce the issue
- Proof-of-concept or exploit code (if possible)
- Impact of the issue

## Security Best Practices

When deploying SwiftRoute:

1. **Never commit `.env` files** — Use environment variables
2. **Use HTTPS** — Always deploy with TLS certificates
3. **Update dependencies** — Run `composer update` regularly
4. **Set proper permissions** — Storage and bootstrap/cache should be writable
5. **Disable debug mode** — Set `APP_DEBUG=false` in production
6. **Use strong secrets** — Generate secure APP_KEY and database passwords
7. **Configure CORS** — Restrict origins in production
8. **Rate limiting** — Already configured via Laravel's throttle middleware
