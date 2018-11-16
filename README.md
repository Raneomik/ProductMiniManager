# Product mini manager
Symfony 4 / Docker training project

### Requirements

* composer
* node.js and yarn
* docker and docker-compose


### Start app

* Install dependencies:

```
composer install -o

yarn
```

* start docker php 7 server :
```
sudo docker-compose up -d --force-recreate --remove-orphans
```

get containers IP address (if you want to access it by navigator or setup a host):
```
sudo docker inspect -f '{{range .NetworkSettings.Networks}}{{.IPAddress}}{{end}}' product-manager-srv
```


* init and populate db :
```
sudo docker exec -it product-manager-srv bin/console doctrine:schema:update --force
sudo docker exec -it product-manager-srv bin/console doctrine:fixtures:load
```

* build js/css/font/img... assets :
```
yarn build
```

* run tests:
```
sudo docker exec -it product-manager-srv bin/phpunit
```

