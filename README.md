# mylittlelibrary

Installation :

Copier le dépôt

Créée la DB

Lancer l'installation via console (ssh)
```
$ composer install

$ php bin/console doctrine:schema:update --force

$ php bin/console cache:clear --env=prod
```
Pour créer un admin
```
$ php bin/console app:generate-admin mail@mail.com motdepasse

```

