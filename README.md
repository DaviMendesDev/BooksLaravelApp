# BooksLaravelApp
A Laravel application with purpose to be a simple CRUD with Search


# Requirements
- [Laravel 7.x](https://laravel.com/docs/7.x/installation)
- [Node Package Manager (NPM)](https://nodejs.org/en/download/)
- [PostgreSQL](https://www.postgresql.org/download/)

# Setting Up Environment
## Composer Dependencies
After get all requirements you will need get all dependencies to run the Application. 
To do this you must enter on the Laravel project folder
``` /BooksLaravelApp/LibraryApplication ```
and inside that, you must run this command:
```
    composer install
```

## Node Dependencies
To install dependencies with node you must run this command (inside the ``` /BooksLaravelApp/LibraryApplication ``` Project Folder)
```
    npm install
```

## PostgreSQL
This project uses PostgreSQL as the DMS, before you use my application, you must create or set up a database (where the application will insert and retrieve data)

## The ```.env``` File
Every Laravel application uses the ```.env``` file as the main config/base file, your ```.env``` file must looks like the ```.env.example``` file (especifically the DB's configuration data):
```
APP_NAME="Library for you"
APP_ENV=local
APP_KEY=base64:QWW3MTKYovqlSiOuewtUEGESlnY8xIpOhexKJTpbbtE=
APP_DEBUG=true
APP_URL=http://localhost

LOG_CHANNEL=stack

# the specific part
# ----------------------------------------------------
DB_CONNECTION=pgsql
DB_HOST=<YOUR DB HOST (the localhost is '127.0.0.1')>
DB_PORT=<YOUR DB PORT (the default port of PostgreSQL is 5432)>
DB_DATABASE=<YOUR DB NAME>
DB_USERNAME=<YOUR DB USERNAME>
DB_PASSWORD=<YOUR DB PASSWORD>
# ----------------------------------------------------

BROADCAST_DRIVER=log
CACHE_DRIVER=file
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS=null
MAIL_FROM_NAME="${APP_NAME}"

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=

PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
PUSHER_APP_CLUSTER=mt1

MIX_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
MIX_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"

```
The places that starts with '<' and ends with '>' symbols, must be replaced with your own data.

## Finally
After you configure your environment, you must run this command to turn on your configurations on the application:
```
    php artisan config:cache
```

The Styles on this project are written on Sass, so you need to compile it before you use, this command will compile the styles:
```
    npm run dev
```

Then run the migration (to setup the tables on database) with this command:
```
    php artisan migrate
```

And after all this, you can run your application, using this command:
```
    php artisan serve
```
The application will run on the port ```8000``` on ```http://localhost```
