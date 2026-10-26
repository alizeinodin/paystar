# PayStar Payment Gateway Demo

A small e-commerce checkout built with **Laravel 10** and **Vue 3** that integrates the **PayStar** online payment gateway end to end: create a payment, redirect the user to the bank, handle the callback, and verify the transaction.

---

## Features

- **Authentication** — Laravel auth scaffolding plus Sanctum-protected API routes
- **Products & orders** — buy a product, which creates an order and requests a payment token from PayStar
- **Saved credit cards** — users register their cards; a custom validation rule ensures a card belongs to the current user
- **Secure gateway integration** (`app/Traits/Payment.php`) — HMAC-SHA512 signed requests for `create`, `payment`, and `verify`
- **Callback verification** — on return from the bank, the masked card number is checked against the card the user selected before the transaction is verified
- **Vue 3 SPA** — Vue Router + Vuetify frontend bundled with Vite

## Tech stack

- PHP 8.1+, Laravel 10, Laravel Sanctum
- Guzzle HTTP client
- Vue 3, Vue Router, Vuetify, Vite
- MySQL (Docker Compose / Sail)

## API overview

| Method | Endpoint | Description |
|--------|----------|-------------|
| `GET` | `/api/card/all` | List the user's saved cards |
| `POST` | `/api/card/store` | Save a new card |
| `POST` | `/api/order/buy/{product}` | Create an order and get a payment token |
| `GET` | `/order/callback` | Gateway callback (verifies the payment) |
| `GET` | `/api/auth/user` | Current user |

## Getting started

```bash
git clone https://github.com/alizeinodin/paystar.git
cd paystar
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate
npm run build
php artisan serve
```

Set your gateway credentials in `.env`:

```dotenv
PAYSTAR_BASE_URL=
PAYSTAR_GATEWAY_ID=
PAYSTAR_KEY=
PAYSTAR_CALLBACK_URL=
```

## Tests

```bash
php artisan test
```

> The order purchase feature test calls the real PayStar API, so it needs valid gateway credentials and network access.

## License

[MIT](LICENSE)
