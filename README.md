<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

[//]: # (<p align="center"><a href="https://quasar.dev/" target="_blank"><img src="https://cdn.quasar.dev/logo-v2/svg/logo-vertical.svg" width="270"></a></p>)

## Installation

```sh
composer install
```

```sh
npm install
```

```sh
cp .env.example .env
```

---
Create an SQLite database. You can also use another database (MySQL, Postgres), simply update your configuration
accordingly.

```sh
cp database.sqlite database
```

or

```sh
touch database/database.sqlite
```

---

```sh
php artisan key:generate
```

```sh
php artisan migrate
```

```sh
php artisan db:seed
```

```sh
npm run dev
```

```sh
php artisan serve
```

---

```
test@example.com
```

```
12345678
```

---

## About

JSON API для сайта объявлений как тестовое задание.

Сервис для хранения и подачи объявлений. Объявления хранятся в базе данных.

Сервис предоставляет API, работающее поверх HTTP в формате JSON.

### 3 метода:

- получение списка объявлений
- получение одного объявления
- создание объявления

Валидация полей (не больше 3 ссылок на фото, описание не больше 1000 символов, название не больше 200 символов).

### Метод получения списка объявлений:

- Пагинация, на одной странице 10 объявлений
- Сортировка: по цене (возрастание/убывание) и по дате создания (возрастание/убывание)
- Поля в ответе: название объявления, ссылка на главное фото (первое в списке), цена

### Метод получения конкретного объявления:

- Обязательные поля в ответе: название объявления, цена, ссылка на главное фото
- Опциональные поля (можно запросить, передав параметр fields): описание, ссылки на все фото

### Метод создания объявления:

- Принимает все вышеперечисленные поля: название, описание, несколько ссылок на фотографии, цена
- Возвращает ID созданного объявления и код результата (ошибка или успех)

Unit тесты для backend части.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
