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

### 4. Install gateway dependencies

```bash
cd gateway
npm install
```

#### Environment setup

```bash
cp gateway/.env.example gateway/.env
```

Then fill in the required values in `gateway/.env` :
- `USERS_SERVICE_URL` — URL of the users-service GraphQL endpoint
- `POSTS_SERVICE_URL` — URL of the posts-service GraphQL endpoint

### 5. Start the project

```bash
docker-compose up --build
```

This starts :
- `db-users` on port 3306
- `db-posts` on port 3307
- `users-service` on port 8001
- `posts-service` on port 8002
- `gateway` on port 4000

### 6. Run migrations

```bash
docker-compose exec users-service php artisan migrate
docker-compose exec posts-service php artisan migrate
```

### 7. Query the API

Open Postman or any GraphQL client at :

```
http://localhost:4000/graphql
```