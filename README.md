# GitHub Repo Tracker

[![GitHub Issues](https://img.shields.io/github/issues/kvintessen/github-repo-tracker)](https://github.com/kvintessen/github-repo-tracker/issues)
[![GitHub Forks](https://img.shields.io/github/forks/kvintessen/github-repo-tracker)](https://github.com/kvintessen/github-repo-tracker/network)
[![GitHub Stars](https://img.shields.io/github/stars/kvintessen/github-repo-tracker)](https://github.com/kvintessen/github-repo-tracker/stargazers)
[![License](https://img.shields.io/github/license/kvintessen/github-repo-tracker)](https://github.com/kvintessen/github-repo-tracker/blob/main/LICENSE)

## Описание

GitHub Repo Tracker — это приложение на **Yii2**, которое позволяет отслеживать репозитории пользователей GitHub. Приложение собирает информацию о последних обновлениях репозиториев и предоставляет удобный интерфейс для просмотра данных.

## Технологии

- **Фреймворк:** Yii2
- **База данных:** MySQL
- **Контейнеризация:** Docker, Docker Compose
- **Сервисные инструменты:** PHP-FPM, Supervisor, Cron

## Требования

Перед началом убедитесь, что на вашем компьютере установлены следующие инструменты:

- [Docker](https://www.docker.com/get-started) (версия 20.10.0 и выше)
- [Docker Compose](https://docs.docker.com/compose/install/) (версия 1.27.0 и выше)
- [Git](https://git-scm.com/downloads)

## Установка

### 1. Клонирование Репозитория

Сначала клонируйте репозиторий на свой локальный компьютер:

```bash
git clone https://github.com/kvintessen/github-repo-tracker.git
cd github-repo-tracker
```

### 2. Настройка Docker
   Перейдите в директорию .docker, где находятся файлы конфигурации Docker:
```bash
cd .docker
```

### 3. Запуск Контейнеров
   Соберите и запустите Docker-контейнеры в фоновом режиме с помощью Docker Compose:

```bash
docker compose up --build -d
```

### 4. Выполнение Миграций
   После запуска контейнеров необходимо выполнить миграции для настройки базы данных. Для этого выполните следующие шаги:

Вход в Контейнер Приложения

#### 1. Зайдите внутрь контейнера с приложением:

```bash
docker exec -ti github-repo-tracker-app bash
```

#### 2. Внутри контейнера выполните миграции:

```bash
php yii migrate
```

### 5. Host
Сайт доступен по адресу 

http://localhost:8080/


