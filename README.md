# AbeloHost

* PHP 8.1
* MySQL 9
* Smarty 5

## Разворачивание:

1. Клонировать репозиторий:

       git clone git@github.com:yvalynets/abelo-host.git

2. Скопировать `.env.example` в `.env`. При необходимости изменить настройки:
   * `DOCKER_UID` - ID пользователя Linux (по умолчанию 1000)
   * `DOCKER_GID` - ID группы Linux (по умолчанию 1000)
   * `DOCKER_SITE_PORT` - порт на хосте для доступа к сайту (по умолчанию 80)
   * `DOCKER_DB_PORT` - порт на хосте для доступа к базе данных (по умолчанию 3306)

3. Собрать и запустить контейнеры:

       docker compose up -d

4. Добавить пакеты:

       docker compose exec -u www-data php composer install
