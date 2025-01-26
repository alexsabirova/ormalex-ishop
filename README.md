## Installation

- composer install
- php artisan app:install
- make .env and .env.testing from .env.example

## 🚀 Стек

- PHP 8.2, Laravel 11, PHPUnit
- MySQL, Redis
- Docker, Sentry, Laravel Telescope, git
- Moonshine Admin Panel

## Архитектура

- `DDD` Разбиение проекта на домены и на ответственности; внесение изменений в autoload и в моделях
- `State Design Pattern` для работы со статусами заказа
- `EAV` модель - сущность, атрибут, значение; для карточки Продукта
- Паттерн `ViewModels` (для передачи данных в представление)
- Паттерн `Composite` (для меню)

## Backend

- `ORM Eloquent`: отношения, атрибуты, casts, valueobject, scope, querybuilder,  enum
- `traits`: создание и подключение кастомных трейтов
- `Service Provider`: добавление своих методов, регистрация и прокидывание своих провайдеров
- `Request/Validate`; создание кастомных `rules`, регулярные выражения
- `Listeners/Notifications`: отправка писем на событие регистрации
- `API Github` для авторизации через github используя socialite
- Создание helpers и прокидывание в autoload
- `DTO`, `casts` (мобильный номер) , `ValueObjects` (для цены), `attributes` (подсчет стоимости)
- `Cache`: кэширование запросов
- Полнотекстовый Поиск, Сортировки, Фильтры: работа с полнотекстовым поиском
- `Iterator, Countable, JsonSerializable`: работа с интерфейсами
- `Queue/Job`: перегенерация json файлов
- `Exceptions`: создание кастомных исключений
- `Pipeline`: паттерн для работы с транзакциями
- Заготовка для подключения эквайринг-систем оплаты
- Админ-панель для добавления, удаления, изменения товаров

### Frontend

- Подключение и настройка `Vite`; установка `node, tailwind, sass, postcss`
- `Blade` и оживление верстки
- `aplineJS` как аналог полновесных фронтенд-фреймворков

### Окружение и отладка

- `xDebug`
- `Sentry`
- `Laravel Telescope`
- `Debugbar`
- Кастомные консольные команды
- `CI github actions `
- `CD` c Envoyer

### Тестирование

- Настройка `phpunit.xml`
- Фабрики c тестовыми данными
- `mock` тестирование: socialite, очереди
- prehook на git commit для автоматического запуска тестов
