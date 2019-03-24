Установка:

`git clone https://github.com/igor-z/husky-test`

`cd husky-test`

Устанавливаем пакеты composer'а:
`composer install`

Устанавливаем пакеты npm:
`npm install`

Собираем пакеты webpack'ом:
`npm run build`

Запускаем контейнер:
`sudo docker-compose up -d`

Подключаемся к контейнеру:
`sudo docker exec -it husky-test_web_1 /bin/bash`

В контейнере:

`./init --env=Development`

`./yii migrate`

Админка доступна по адресу
`http://localhost/backend/`