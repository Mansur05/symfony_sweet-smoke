## Tech. task on Symfony by Sweet Smoke
У сущностей должен быть минимальный набор полей для корректного отображения по макету!

Все изменения БД должны быть записаны через миграции.
Подключить SonataAdmin, SonataMedia к проекту. Реализовать загрузку изображений для сущностей, в которых есть картинки!
Сделать возможность добавлять и выводить товар в блок «Popular Arrivals». (смотреть макет!)
Реализовать добавление блоков в «LatestBlog». (смотреть макет!)
### Get start

git clone

composer install

php bin/console doctrine:migrations:migrate

php bin/console doctrine:fixtures:load

php bin/phpunit

symfony server:start

>Admin Panel 
>login/password = admin