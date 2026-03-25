# Pokemon Sync App

Simple Laravel app for importing Pokemon from PokeAPI, storing them locally, and managing them through an authenticated UI.

## What it does

- imports Pokemon from the PokeAPI list endpoint and then fetches each Pokemon's detail endpoint
- stores the data in a local database
- lets authenticated users browse all Pokemon
- lets authenticated users view a single Pokemon
- lets authenticated users re-sync one Pokemon from the API
- lets authenticated users edit the local record
- includes a full "Sync All" action from the UI

## Stack

- Laravel 13
- PHP 8.3
- Laravel Fortify for auth
- Tailwind CSS 4
- PostgreSQL
- Laravel database queue

## Setup

1. Clone the repo and move into the project:

```bash
git clone <your-repo-url>
cd sync_pokemon_app
```

2. Install PHP and Node dependencies:

```bash
composer install
npm install
```

3. Create your env file if you do not already have one:

```bash
cp .env.example .env
```

4. Create your local database and update `.env` if needed.

This project is set up for PostgreSQL by default. The example `.env` expects a database called `sync_pokemon_app` on `127.0.0.1:5432`.

If you already have PostgreSQL running locally, you can create that database with:

```bash
createdb sync_pokemon_app
```

You can also create it manually in a database tool like TablePlus, DBeaver, or anything similar.

The usual flow there is:

- create a new PostgreSQL connection
- use your local host, port, username, and password
- connect to the server
- create a new database called `sync_pokemon_app`

Then make sure the matching `DB_*` values in `.env` use that same connection info.

If you use Herd and already have PostgreSQL available there, just create a local database named `sync_pokemon_app` in your usual database tool and keep the default env values, or change the `DB_*` values in `.env` to match your setup.

The main values to check are:

```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=sync_pokemon_app
DB_USERNAME=your-local-username
DB_PASSWORD=your-local-password
```

5. Generate the app key:

```bash
php artisan key:generate
```

6. Run migrations:

```bash
php artisan migrate
```

That will create the app tables plus the database-backed cache, session, and queue tables this project uses.

7. Build frontend assets:

```bash
npm run build
```

## Running locally

### If you use Herd

Herd is the easiest way to run this locally.

If this project lives inside a parked Herd directory, Herd will usually serve it automatically. If it does not, just add the folder as a site in Herd and open the local URL Herd gives you.

Once setup is done, the usual flow is:

```bash
npm run dev
```

If you want the queue-backed `Sync All` button to work from the UI, run a worker in another terminal too:

```bash
php artisan queue:work
```

Then open the Herd local URL for the project and use the app normally.

### If you are not using Herd

Start the Laravel app with:

```bash
php artisan serve
```

Run Vite in another terminal too:

```bash
npm run dev
```

## Auth

I used Laravel Fortify for auth instead of Jetstream.

That was mainly because the brief only needed simple login/register protection around the Pokemon pages. Jetstream felt like more than I needed here since it brings a fuller starter app structure and extra opinionated UI/features. Fortify gave me the auth backend I needed, but let me keep the screens and flow small and custom.

So basically:

- Fortify handles login, registration, and logout
- the Pokemon pages sit behind `auth` middleware
- guests get redirected to login

## Running the sync

### Run the sync command directly

This runs the import in the terminal:

```bash
php artisan pokemon:sync
```

### Run the full sync from the UI

The "Sync All" button dispatches a queued job so the browser does not sit there waiting for the full import to finish.

Because of that, if you want to use the button from the UI, run a queue worker in another terminal:

```bash
php artisan queue:work
```

Then log in and click `Sync All`.

The queued `Sync All` job implements Laravel's `ShouldBeUnique` contract. That means if a full sync job is already queued or currently running, clicking `Sync All` again will not dispatch a second copy of the same job.

In this app, that uniqueness lock is backed by the database cache driver, so the lock is stored in the `cache_locks` table until Laravel releases it after the job completes or finally fails.

One small UI limitation right now is that the controller still flashes the same "sync started" success message even when a repeat click was ignored because a sync is already in progress.

## Running tests

Run the full test suite:

```bash
php artisan test
```

Or just run the import test:

```bash
php artisan test --filter=PokemonImportTest
```

## My approach

I kept this pretty straightforward on purpose.

The brief said to keep it simple and well-finished, so I tried not to overcomplicate things.

Main decisions I made:

- I used a `pokemon` table with the required fields plus `external_id` and `api_url` so I had a stable reference back to the API.
- I used `updateOrCreate` in the sync command so repeated syncs behave like an upsert.
- I kept the Pokemon UI server-rendered with Blade and Tailwind because the app did not need a JS-heavy frontend.
- I used a queue for the full sync button because the browser waiting on a long import felt like a bad experience.
- I kept the single-Pokemon re-sync synchronous because it is small and immediate.

## Trade-offs

- The full sync is intentionally simple and reads through the API one Pokemon at a time. That keeps the logic easy to follow, even if it is not the most optimized possible version.
- I chose readability over building a more abstract sync pipeline.
- I kept auth lightweight with Fortify rather than pulling in a bigger auth/UI package.

If I pushed this further, the next cleanup I would do is move the shared sync logic into a dedicated service so both the command and queued job call the same class directly.

I would also make the sync experience feel more polished in the UI. A nicer version would show a spinner or loading state while the full sync is running, then poll the backend every 5/10 seconds to check for status updates and refresh the page state. That repeated check is polling rather than scheduling. I would also tighten up the messaging around duplicate clicks and overall make that part of the UI feel nicer, but I wanted to keep this version focused on the core functionality.

The edit flow is also intentionally simple right now. From the list view, you click into a Pokémon by its name and then edit it from the detail page. If I polished the UI further, I would make that action more obvious with a separate Edit button in the table instead of relying on the clickable name as the main way in.
