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
cp users-service/.env.example users-service/.env
```

Then fill in the required values in `users-service/.env` :
- `DB_PASSWORD` — your MySQL password
- `JWT_SECRET` — generated in the next step

### 4. Generate JWT secret

```bash
cd users-service
php artisan jwt:secret
```

> Automatically adds `JWT_SECRET` to your `.env`. Never commit this value.

### 5. Configure auth guard

In `config/auth.php` :
- Set default guard to `api`
- Add JWT driver to `api` guard

See `users-service/config/auth.php` for the full configuration.