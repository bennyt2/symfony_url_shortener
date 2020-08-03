# URL Shortener

This Symfony URL shortener does the following:

* Allows a user to enter a URL and receive a shortened URL.
* Allows a user to define a slug or get a random one.

## Installation

1. Checkout this repo and `cd` into it.
2. Create a MySQL database and fill out the `DATABASE_URL` in `.env`.
3. Run `composer install`. This will also run doctrine migrations to populate the database with appropriate tables.

## Usage

1. Run `symfony server:start`.
2. Go to localhost:8000

## Tests

### Before running tests

1. Create a MySQL database and put the connection string into `.env.test`.
2, Run `bin/console doc:mi:mi` to populate the test database with appropriate tables.

### Running tests

Run `bin/phpunit`. 

