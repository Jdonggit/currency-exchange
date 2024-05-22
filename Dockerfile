# 定義 composer_builder 階段
FROM composer:latest AS composer_builder
WORKDIR /source
COPY composer.* ./
RUN composer install --no-scripts && composer clear-cache
COPY . .
RUN composer run post-autoload-dump


# 基礎映像
FROM php:8.3-fpm-alpine AS base
WORKDIR /var/www


RUN apk add --no-cache unzip libzip-dev zip libpng-dev nginx \
   && apk add --no-cache --virtual .build-deps autoconf g++ make \
   && docker-php-ext-install zip pdo_mysql \
   && apk del .build-deps


# 複製 composer 依賴
COPY --from=composer_builder /source/vendor ./vendor


# 複製應用程式文件
COPY . .
RUN touch ./database/database.sqlite


# 設置權限和用戶
RUN addgroup -g 1000 project_user \
   && adduser -u 1000 -s /bin/bash -G project_user project_user -D \
   && chmod -R 755 . \
   && chmod -R ugo+rw storage \
   && chown project_user:project_user .


# 複製 nginx 配置文件
COPY ./.docker/nginx/nginx.conf /etc/nginx/nginx.conf
COPY ./.docker/nginx/project.conf /etc/nginx/conf.d/project.conf


# 暴露端口
EXPOSE 80


# 啟動 php-fpm 和 nginx
CMD ["sh", "-c", "php-fpm -D && nginx -g 'daemon off;'"]
