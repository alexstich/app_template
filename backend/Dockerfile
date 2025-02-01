FROM yiisoftware/yii2-php:8.3-fpm-nginx

# Установка Node.js и npm
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && npm install -g npm@latest

WORKDIR /app

# Копировать composer.json и composer.lock
COPY composer.json composer.lock ./

# Копировать остальные файлы приложения
COPY . .

# Установка зависимостей composer с правильными правами
RUN composer install --no-scripts --no-autoloader

# Копировать конфигурационные файлы
COPY etc/docker/php/php.ini /usr/local/etc/php/conf.d/custom-php.ini
COPY etc/docker/nginx/conf.d/timeout.conf /etc/nginx/conf.d/timeout.conf
COPY etc/docker/nginx/conf.d/nginx.conf /etc/nginx/conf.d/default.conf
COPY etc/docker/scripts/make_migrations.sh /make_migrations.sh

# Финальная настройка composer и прав доступа
RUN composer dump-autoload --optimize \
    && chmod +x /make_migrations.sh \
    && chown -R www-data:www-data /app \
    && chmod -R 755 /app/vendor

# Добавить пользователя с ограниченными правами
RUN useradd -m admin
USER admin

EXPOSE 80

# Добавить healthcheck
HEALTHCHECK --interval=30s --timeout=10s --start-period=5s --retries=3 \
    CMD curl -f http://localhost/health || exit 1 