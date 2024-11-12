# PHP Weather API

A PHP-based Weather API that fetches and returns weather data from [Visual Crossing's API](https://www.visualcrossing.com/weather-api) uses [predis](https://github.com/predis/predis) for [Redis](https://redis.io) cache and [phpdotenv](https://github.com/vlucas/phpdotenv) for loads environment variables. This project inspired by [roadmap.sh](https://roadmap.sh/projects/weather-api-wrapper-service).

## **Getting started guide**

To start using the Expense Tracker API, you need to -

1. Clone the repository.

   ```bash
   git clone https://github.com/krisnaajiep/php-weather-api.git

   ```

2. Install dependencies.

   ```bash
   composer install

   ```

3. Configure `.env` file.

   ```bash
   cp .env.example .env

   ```

4. Configure API key and Redis connection in `.env` file.

   ```
   API_BASE_URL="https://weather.visualcrossing.com/VisualCrossingWebServices/rest/services/timeline/"
   API_KEY=""

   REDIS_HOST=127.0.0.1
   REDIS_PASSWORD=null
   REDIS_PORT=6379
   REDIS_CACHE_DB=0
   ```

5. Run the PHP built-in server.

   ```bash
   php -S localhost:8000

   ```

6. Access the endpoint with location query parameter.

   Example:

   ```
   http://localhost:8000/?location=jakarta
   ```

### **Need some help?**

In case you have questions or need further assistance, you can refer to the following resources:

- [Visual Crossing's API Documentation](https://www.visualcrossing.com/resources/documentation/weather-api/timeline-weather-api/)
