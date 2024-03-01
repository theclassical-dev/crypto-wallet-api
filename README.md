# crypto-wallet-api
```
This Project encompasses a user authentication and cryptocurrency wallet system. Users can register, obtain access tokens for authentication,
and manage their wallets for various cryptocurrencies. The system allows users to check their wallet balances, perform fund transfers between wallets,
generate new wallets, and view transaction histories. Cryptocurrency balances are dynamically converted based on live market rate.
The API documentation is written in the OpenAPI specification and rendered with Rapidoc.


```
## How to view the Documentation

```
After installation, run php artisan serve and copy the URL provided into your browser.

```

## Installation Instructions

### 1. Clone the Repository:

```bash
git clone <repository_url>
cd your_project_name

```
### 2.Composer install in terminal

```bash
composer install

```
### 3. Copy  .env file & Generate Application Key

```bash

cp .env.example .env
php artisan key:generate

```
### 4. Configure the Database

```
Update the .env file with your database configuration,
then run: php artisan migrate to migrate the migration files to the database.

```
### Then Serve the Application
```
php artisan serve
