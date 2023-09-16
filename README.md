

# Проект Support API

## Установка

1. Клонировать проект на локальный компьютер
2. Установить все зависимости
~~~
./vendor/bin/sail composer update
~~~
3. Мигрировать базу
~~~
./vendor/bin/sail artisan migrate
~~~
4. Запустить seeder
~~~
./vendor/bin/sail artisan db:seed
~~~
5. Запустить контейнеры
~~~
./vendor/bin/sail up
~~~

Ссылка на документацию API на основе Swagger `/api/documentation`

## Тестовые данные пользователей

### Обычный пользователь

Почта- user@test.com <br>
Пароль - user

### Ответственное лицо

Почта - support@test.com <br>
Пароль - support
