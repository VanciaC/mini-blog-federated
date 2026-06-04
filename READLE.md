# Mini Blog Federated

A federated GraphQL API built with Laravel microservices and Apollo Gateway.

## Prerequisites

- PHP 8.3
- Composer
- Node.js 20+
- Docker & Docker Compose

## Getting Started

### 1. Clone the repository

```bash
git clone https://github.com/your-username/mini-blog-federated.git
cd mini-blog-federated
```

### 2. Install users-service dependencies

```bash
cd users-service
composer install
```

### 3. Environment setup

```bash
cp .env.example .env
```

### 4. Generate JWT secret

```bash
php artisan jwt:secret
```

> Automatically adds `JWT_SECRET` to your `.env`. Never commit this value.

### 5. Configure auth guard

In `config/auth.php`, set the default guard to `api` and add the JWT driver.
See `config/auth.php` for the full configuration.