Установка:

Уже должны быть установлены: composer, npm или yarn, docker, docker-compose.

После этого выполняем команды:

`git clone https://github.com/igor-z/husky-test && cd husky-test`

`composer install`

`npm install`

`npm run build`

`sudo docker-compose up -d`

Если имя запущенного контейнера отличается от `husky-test_web_1`, то подставляем его:

`sudo docker exec -it husky-test_web_1 /bin/bash`

В контейнере:

`./init --env=Development`

`./yii migrate`

Админка доступна по адресу
`http://localhost/backend/`