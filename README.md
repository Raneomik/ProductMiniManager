# Product mini manager
Symfony 4 / Docker training project

### Requirements

* composer
* node.js and yarn
* docker and docker-compose


### Start app

```
composer install -o
```

start docker php 7 server :
```
sudo docker-compose up -d --force-recreate --remove-orphans
```

get containers IP address :
```
sudo docker inspect -f '{{range .NetworkSettings.Networks}}{{.IPAddress}}{{end}}' product-manager-srv
```


init db :
```
sudo docker exec -it product-manager-srv bin/console doctrine:database:create
sudo docker exec -it product-manager-srv bin/console  doctrine:schema:create

```

build assets :
```
yarn build
```