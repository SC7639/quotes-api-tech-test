# Quotes API

## Running App

-   First install docker if you don't already have docker installed https://docs.docker.com/get-docker/
-   Run `composer install` or if composer is not installed run `docker run --rm --interactive --tty --volume $PWD:/app composer install`
-   Copy `.env.example` to `.env` and generate a random api key from [generate-random.org](https://generate-random.org/api-key-generator?count=1&length=128&type=mixed-numbers&prefix=)
-   Add the random api key to `.env` file with the key `API_TOKEN` key
-   Run `./vendor/bin/sail up --build -d` to start the project using docker and laravel sail

## Testing

-   If using an app like postman add a new request to `http://localhost/api/quotes/` with authorization `Barer Token` and use the value from `API_TOKEN` in `.env` or you can run in the console

```
curl --location 'localhost/api/quotes/' \
--header 'Authorization: Bearer ${API_TOKEN}'
```

-   You will get the same quotes each time you hit the `api/quotes/` endpoint as it. If you want to refresh the quotes using either of the above methods hit `api/quotes/refresh`
-   To run the feature tests run `./vendor/bin/sail artisan test`

# Description

Initial call of `/api/quotes/` endpoint, will make an api request and fetch fresh quotes (in parallel) and then stores/caches those results in redis. Subsequent hits of the `/api/quotes` endpoint gets the results from the redis cache. On call of `/api/quotes/refresh` endpoint then hits the api again and fetches fresh quotes and overrides the current cached quotes and returns the quotes, then further calls to `/api/quotes/` will return the newly cached quotes.
