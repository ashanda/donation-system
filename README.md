# Laravel Docker Setup

This repository contains a Docker setup for running a Laravel application using PHP 8.2-FPM.

## Prerequisites

Ensure you have the following installed on your system:
- Docker
- Docker Compose

## Setup Instructions

1. **Clone the repository**

    ```sh
    git clone https://github.com/ashanda/donation-system.git
    cd donation-system
    ```

2. **Build the Docker image**

    ```sh
    docker-compose build
    ```

3. **Run the Docker containers**

    ```sh
    docker-compose up -d
    ```

4. **Install PHP dependencies using Composer**

    ```sh
    docker-compose exec app composer install
    ```

5. **Set up environment variables**

    Copy the `.env.example` file to `.env` and configure your environment variables:

    ```sh
    cp .env.example .env
    ```

6. **Generate application key**

    ```sh
    docker-compose exec app php artisan key:generate
    ```

7. **Run database migrations**

    ```sh
    docker-compose exec app php artisan migrate
    ```

## Directory Structure

- `/var/www` - This is the working directory for the Laravel application inside the Docker container.

## Services

- `app` - The Laravel application running on PHP 8.2-FPM.

## Exposed Ports

- `9000` - PHP-FPM port exposed by the Docker container.

## Common Commands

- **Access the PHP container's shell**

    ```sh
    docker-compose exec app bash
    ```

- **Run artisan commands**

    ```sh
    docker-compose exec app php artisan <command>
    ```

- **Run Composer commands**

    ```sh
    docker-compose exec app composer <command>
    ```

## Cleaning Up

To stop the Docker containers:

```sh
docker-compose down
