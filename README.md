# Strichlistensystem

## Usage

### production
This project uses laravel octane with roadrunner as production server. You can install the server with:
_This step will also ask you to download the roadrunner binary._

```sh
php artisan octane:install
```

You can run the production server with:
_Define the worker-count and max-requests to fit your needs._

```sh
php artisan octane:start --max-requests=512 --workers=4
```

### docker

If you want to use docker, use the following commands:

```sh
docker build -t ghcr.io/fsr5-fhaachen/strichlistensystem:latest .
docker-compose up -d
docker exec -it strichlistensystem-web php artisan migrate:fresh --seed
```