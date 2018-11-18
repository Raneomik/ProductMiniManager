# Product mini manager
Symfony 4 / Docker training project

### Requirements

* PHP 7.1 (with ext curl, mbstring activated localy)
* composer
* node.js (min v8) and yarn (v1)
* docker and docker-compose


### Start app

* Install php and js dependencies:

```
composer install -o

yarn
```

* start docker php 7 server :
```
sudo docker-compose up -d
```

get containers IP address (if you want to access it by navigator and/or setup a host):
```
sudo docker inspect -f '{{range .NetworkSettings.Networks}}{{.IPAddress}}{{end}}' product-manager-srv
```


* init and populate db :
```
sudo docker exec product-manager-srv php bin/console doctrine:schema:update --force
sudo docker exec product-manager-srv php bin/console doctrine:fixtures:load
```

* build js/css/font/img... assets :
```
yarn build
```

* run tests :
```
sudo docker exec product-manager-srv bin/phpunit
```

