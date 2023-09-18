# Проект Support API

## Установка

1. Клонировать проект на локальный компьютер

2. Установить все зависимости

~~~
./vendor/bin/sail composer update
~~~

3. Копировать `.env.example` под именем `.env`

4. Запустить контейнеры

~~~
./vendor/bin/sail up
~~~

5. Мигрировать базу

~~~
./vendor/bin/sail artisan migrate
~~~

6. Запустить seeder

~~~
./vendor/bin/sail artisan db:seed
~~~

### Запуск тестов

~~~
./vendor/bin/sail artisan test
~~~

Ссылка на документацию API на основе Swagger `/api/documentation`

## Тестовые данные пользователей

### Обычный пользователь

Почта- user@test.com <br>
Пароль - user

### Ответственное лицо

Почта - support@test.com <br>
Пароль - support
