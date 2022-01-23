# mylittlelibrary

## *Installation*

Copier le dépôt

Créée la DB et indiquer les informations nécessaires dans .env

Lancer l'installation via console (ssh)
```
$ composer install

$ php bin/console doctrine:schema:update --force

$composer dump-env prod

$ php bin/console cache:clear --env=prod
```
Pour créer un admin
```
$ php bin/console app:generate-admin mail@mail.com motdepasse

```
