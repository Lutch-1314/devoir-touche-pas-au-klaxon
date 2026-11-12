# Touche pas au klaxon

## Vérification de la qualité

Le projet utilise [PHPStan](https://phpstan.org/) au niveau 5 pour l'analyse statique et PHPUnit pour vérifier les écritures des modèles `Agency` et `Trip` sur une base SQLite temporaire.

Après avoir installé les dépendances Composer, exécutez les vérifications depuis la racine du projet :

```sh
composer install
composer analyse
composer test
```

Les commentaires PHP de l'application utilisent des DocBlocks pour documenter les classes et leurs méthodes.