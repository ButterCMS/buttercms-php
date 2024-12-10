FROM php:8.2-cli

WORKDIR /app
COPY . .

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer install

ENV API_BASE_URL=https://api.buttercms.com/v2
ENV API_KEY=your_api_key

CMD ["php", "demo/demo.php"]