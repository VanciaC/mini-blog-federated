## Getting Started

### Prerequisites

- PHP 8.3
- Composer
- Node.js 20+
- Docker & Docker Compose

### 1. Clone the repository

```bash
git clone https://github.com/your-username/mini-blog-federated.git
cd mini-blog-federated
```

### 2. Environment setup

```bash
# users-service
cp users-service/.env.example users-service/.env

# posts-service
cp posts-service/.env.example posts-service/.env
```

Then fill in the required values in each `.env` :
- `DB_PASSWORD` — your MySQL password
- `JWT_SECRET` — generated in the next step

> `JWT_SECRET` must be identical in both services — they need to validate the same tokens.

### 3. Generate JWT secrets

```bash
# users-service
cd users-service && php artisan jwt:secret

# posts-service
cd ../posts-service && php artisan jwt:secret
```

> Automatically adds `JWT_SECRET` to your `.env`. Never commit this value.