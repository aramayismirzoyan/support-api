# Support API

#### API for customer interaction with support service

## Installation

1. Clone a project to your local computer

2. Install all dependencies

~~~
./vendor/bin/sail composer update
~~~

3. Clone `.env.example` as `.env`

4. Launch containers

~~~
./vendor/bin/sail up
~~~

5. Launch migrations

~~~
./vendor/bin/sail artisan migrate
~~~

6. Launch seeders

~~~
./vendor/bin/sail artisan db:seed
~~~

### Launch tests

~~~
./vendor/bin/sail artisan test
~~~

Link to Swagger based API documentation `/api/documentation`

## User test data for login

### Simple user

Email - user@test.com <br>
Password - user

### Responsible person

Email - support@test.com <br>
Password - support
