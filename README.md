# Медицинская информационная система (Patient Management API)

## Описание проекта
RESTful API для управления медицинскими картами пациентов с возможностью:
- Создания новых пациентов
- Просмотра данных пациентов
- Поиска пациентов
- Добавления медицинских записей

## Требования
- PHP 8.4.1
- Composer 2.8.3
- PostgreSQL 16
- Laravel 12.1.1

## Установка
```bash
git clone https://github.com/0SouthBoss0/info-doctor.git
cd info-doctor
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve
```

# API Endpoints
## 1. Создать пациента
```POST /api/v1/add-patients```

Тело:

```json
{
    "first_name": "Antonio",
    "last_name": "Banderas",
    "age": 64
}
```
Ответ:
```json
{
    "data": {
        "first_name": "Antonio",
        "last_name": "Banderas",
        "middle_name": null,
        "age": 64,
        "medical_history": null,
        "updated_at": "2025-04-07T13:41:57.000000Z",
        "created_at": "2025-04-07T13:41:57.000000Z",
        "id": 13
    }
}
```
## 2. Получить информацию о пациенте по ID

```GET /api/v1/patients/{id}```

Пример:

```GET /api/v1/patients/13```

Ответ:
```json
{
    "data": {
        "id": 13,
        "first_name": "Antonio",
        "last_name": "Banderas",
        "middle_name": null,
        "age": 64,
        "medical_history": null,
        "created_at": "2025-04-07T13:41:57.000000Z",
        "updated_at": "2025-04-07T13:41:57.000000Z"
    }
}
```
## 3. Поиск пациентов

```GET /api/v1/search-patients?```

Пример:

```GET /api/v1/search-patients?first_name=Antonio&age=64```

Ответ:

```json
{
    "data": [
        {
            "id": 13,
            "first_name": "Antonio",
            "last_name": "Banderas",
            "middle_name": null,
            "age": 64,
            "medical_history": null,
            "created_at": "2025-04-07T13:41:57.000000Z",
            "updated_at": "2025-04-07T13:41:57.000000Z"
        }
    ]
}
```
## 4. Добавить медзапись

```POST /api/v1/patients/add-medical-history/{id}```

Пример:

```POST /api/v1/patients/add-medical-history/13```

Тело:

```json
{"medical_history": "Small cough."}
```
Ответ:

```json
{
    "data": {
        "id": 13,
        "first_name": "Antonio",
        "last_name": "Banderas",
        "middle_name": null,
        "age": 64,
        "medical_history": "\nSmall cough.",
        "created_at": "2025-04-07T13:41:57.000000Z",
        "updated_at": "2025-04-07T13:44:27.000000Z"
    }
}

```

