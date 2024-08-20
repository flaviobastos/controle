FROM php:8.3.9-fpm-alpine3.20

# Definir o diretório de trabalho dentro do container
WORKDIR /var/www/html

# Instalar extensões PDO e MySQLi
RUN docker-php-ext-install pdo pdo_mysql mysqli

# Copiar os arquivos da aplicação para o diretório de trabalho
COPY . /var/www/html

# Configurar o ponto de entrada e o comando para iniciar o servidor do Laravel
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]



