## Multipizza

Restaurant food delivery system

- Support restaurants in branches
- With User roles: administrators, managers, deliverymen, cooks and other
- Additional ingredients for products in orders
- Order state system with notifications to staff and customer.
- Deliveryman takes free order, it goes in cooking, then picked up and delivered.
- Distance is calculated for delivery, restaurants and order location.

## Getting started

- Clone the repo
- copy `env.example` to `.env`
- set the `DB_` environment variables in `.env` to your liking
- create a database with the name specified in `DB_DATABASE`
- `composer install`
- `yarn`, `yarn run dev` (or the npm equivalents)
- migrate and seed the database with `php artisan migrate:fresh --seed`
- you can now logging in with user "admin@admin.com", password "admin"

## Client API

API schema available at SwaggerHub: https://app.swaggerhub.com/apis/maxbin123/Multipizza/1.0.0

The Multipizza is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
