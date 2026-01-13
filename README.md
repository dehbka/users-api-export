```bash
composer install
npm ci
cp .env.example .env
./vendor/bin/sail up -d
./vendor/bin/sail artisan key:generate
./vendor/bin/sail artisan migrate
# Vite (choose one)
./vendor/bin/sail npm run dev
# or
npm run dev
```
