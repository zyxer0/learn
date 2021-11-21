# Start the project
## First start
On first start run the command
```bash
docker-compose run learning-sphinxsearch indexer --all --config /opt/sphinx/conf/sphinx.conf
```

For start project run the commands
```bash
docker-compose up -d
```
```bash
composer install
```
```bash
yarn install
```
```bash
yarn encore dev
```
```bash
php bin/console doctrine:migrations:migrate
```

# Index rotation
For rotate the sphinx indexes run the command
```bash
docker exec learning-sphinxsearch indexer --rotate --all --config /opt/sphinx/conf/sphinx.conf
```
