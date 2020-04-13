Система
-------------------
Ubuntu-Server 18.04

sudo apt-get install nginx mysql-server sudo apt-get install php-common php-curl php-fpm php-gd php-intl php-mbstring php-mysql php-xml


Composer, vendor и прочая первоначальная настройка
-------------------
 php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
 
 php -r "if (hash_file('SHA384', 'composer-setup.php') === '544e09ee996cdf60ece3804abc52599c22b1f40f4323403c44d44fdfdd586475ca9813a858088ffbc1f233e9b180f061') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
 
 php composer-setup.php
 
 php -r "unlink('composer-setup.php');"
 
 php composer.phar global require "fxp/composer-asset-plugin:1.2.0"
 
 php composer.phar install или php composer.phar update
 
 sudo chown -R www-data runtime/ sudo chown -R www-data web/assets/
 
 После этого необходимо
 
 1) скопировать конфиги из config/origin в config
 -----
 2) написать в файле config/db.php название базы (самому создавать БД НЕ НУЖНО), в последующем база создается с помощью скрипта (незабыть указать и подходящий для mysql логин и пароль) W 3) в консоли выполнить команду
 -----
 3) hp yii app/create-db - этой командой создаем БД из конфига 
 -----
 4) Далее стандартно - просто применить все миграции php yii migrate
 ------
 
 5) Затем создадим админа системы php yii app/add-admin "admin-email@email.com"
  ------
 Примечание: админка вынесена в отдельный модуль modules/admin (доступ через http://bla-bla.foo/admin)