Подкючаем 
```json
 composer require "vis/builder_lara_5":"1.*"
```
В корне проекта в файле .env заменяем подключение к БД на свои

Инсталим админку
```json
   php artisan admin:install
```
Генерируем пароль для админа
```json
   php artisan admin:generatePassword
```

Если нужно обновить css и js, то
```json
   php artisan vendor:publish --tag=public --force
```