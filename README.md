# Laravel Queued Webhooks API

A sample Laravel 12 project to queue webhooks per transaction, prevent out-of-order delivery, and retry failed ones.

## 🧰 Tech Stack

- Laravel 12
- PHP 8.x
- MySQL / PostgreSQL (works with both)
- Queues (sync or db)
- Artisan scheduler for retry
- RESTful API
- Postman collection included

## 🚀 How It Works

- Webhooks are stored in the `queued_webhooks` table
- Each webhook is tied to a `transaction_id`
- Webhooks are processed in order
- If a webhook fails, subsequent webhooks for the same transaction are held
- A scheduled command retries held webhooks every 5 minutes

## Routes

### API Routes

| Method | URI | Description |
|--------|-----|-------------|
| GET | `/api/v1/queued-webhooks` | List all queued webhooks |
| POST | `/api/v1/queued-webhooks` | Create a new queued webhook |
| GET | `/api/v1/queued-webhooks/{queued_webhook}` | Show a specific queued webhook |
| PUT/PATCH | `/api/v1/queued-webhooks/{queued_webhook}` | Update a queued webhook |
| DELETE | `/api/v1/queued-webhooks/{queued_webhook}` | Delete a queued webhook |

### Web Routes

| Method | URI | Description |
|--------|-----|-------------|
| GET | `/webhooks-monitor` | Monitor all queued webhooks |
| PUT | `/webhooks-monitor/{queued_webhook}` | Update a queued webhook's status |
| GET | `/webhooks-monitor/{queued_webhook}/edit` | Edit page for a queued webhook |


## Middleware

The application uses custom middleware:
- `ValidateJsonRequest` - Ensures API requests include the proper JSON headers

> **Note:** When using the API endpoints, ensure proper `Accept: application/json` headers are set.

## 🧪 Testing

Import the `QueuedWebhookAPI.postman_collection.json` file into Postman to test the API.

## ⏱ Cron Setup

To retry held webhooks automatically:

```bash
* * * * * cd /path/to/project && php artisan schedule:run >> /dev/null 2>&1
```

## ⚙️ Getting Started (Run Locally)

### 1. Clone the repo

```bash
git clone https://github.com/your-username/laravel-queued-webhooks.git
```
### 2. Setup 
```bash
cd laravel-queued-webhooks

composer install
cp .env.example .env
php artisan key:generate

###setup database settings 
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=queue_webhook
DB_USERNAME=root
DB_PASSWORD=root


php artisan migrate
php artisan serve

