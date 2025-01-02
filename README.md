# PHP Weather API
> A PHP-based Weather API that fetches and returns weather data from a 3rd party API.

## Table of Contents
* [General Info](#general-information)
* [Technologies Used](#technologies-used)
* [Features](#features)
* [Setup](#setup)
* [Usage](#usage)
* [Project Status](#project-status)
* [Acknowledgements](#acknowledgements)

## General Information
PHP Weather APi is a weather API that fetches and returns weather data from [Visual Crossing's API](https://www.visualcrossing.com/weather-api). This API uses [Redis](https://redis.io) for caching and [phpdotenv](https://github.com/vlucas/phpdotenv) for loads environment variables. This project is designed to explore and practice working with the 3rd party API, Caching and Environment Variables in PHP.

## Technologies Used
- PHP - version 8.3.6
- Redis (via [Predis](https://github.com/predis/predis)) - version 7.4.1

## Features
- **Real-Time Weather Data**: Fetch up-to-date weather information for any location.
- **Location-Based Queries**: Retrieve weather details by specifying the desired location in the query parameter.
- **Caching for Faster Responses**: Utilizes Redis caching to store weather data temporarily, reducing API requests and improving response times.
- **Rate Limiting**: Implements rate limiting to prevent excessive API calls, ensuring fair usage and maintaining service reliability.
- **JSON Responses**: Returns structured JSON data, making it easy to integrate with front-end applications or other systems.
- **Customizable**: Easily configurable base URL and API key via environment variables `.env`, allowing seamless integration with different weather API providers.

## Setup
To run this API, you’ll need:
- PHP: Version 8.3 or newer
- Redis: Version 7.4 or newer
    
How to install:
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

## Usage
Access the endpoint with location query parameter.
```
http://localhost:8000/?location=[location]
```

## Project Status
Project is: _complete_.

## Acknowledgements
This project was inspired by [roadmap.sh](https://roadmap.sh/projects/weather-api-wrapper-service).

