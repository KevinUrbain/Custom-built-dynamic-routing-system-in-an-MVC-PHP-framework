# Routeur PHP From Scratch

Ce projet est un routeur PHP simple et léger, conçu pour illustrer les bases du pattern "Front Controller" et du routage en PHP orienté objet.

## Fonctionnement

Le routeur intercepte toutes les requêtes grâce à une règle de réécriture dans le fichier `.htaccess`. La requête est redirigée vers `public/index.php` qui instancie et exécute le routeur.

Le routeur analyse ensuite l'URL pour déterminer quel contrôleur et quelle méthode appeler. La structure de l'URL est la suivante :

`/controller/method/param1/param2/...`

- **controller** : Le nom du contrôleur à appeler. Si non spécifié, le `HomeController` est utilisé par défaut.
- **method** : Le nom de la méthode à exécuter dans le contrôleur. Si non spécifiée, la méthode `index()` est utilisée par défaut.
- **param1, param2, ...** : Les paramètres à passer à la méthode.

Par exemple, l'URL `/user/findById/123` sera traitée comme suit :

1.  **Contrôleur** : `user` -> `UserController`
2.  **Méthode** : `findById`
3.  **Paramètre** : `123`

Le routeur appellera donc la méthode `findById('123')` de la classe `UserController`.

## Fonctionnalités

- Routage basé sur les segments de l'URL.
- Chargement automatique des contrôleurs (`/user` charge `UserController.php`).
- Appel dynamique des méthodes des contrôleurs.
- Passage des segments d'URL comme paramètres aux méthodes.
- Gestion basique des erreurs 404 (contrôleur, méthode ou fichier non trouvé, nombre de paramètres insuffisant).

## Architecture et `.htaccess`

Pour que le routeur fonctionne, le projet doit respecter la structure de dossiers suivante :

```text
/
├── .htaccess
├── public/
│   └── index.php       # Point d'entrée unique (Front Controller)
└── src/
    ├── Controllers/    # Contient les classes des contrôleurs
    │   ├── HomeController.php
    │   └── UserController.php
    └── Core/
        └── Router.php      # Classe principale du routeur
```

### Le fichier `.htaccess`

Le fichier `.htaccess` à la racine du projet est crucial. Il redirige toutes les requêtes vers le point d'entrée de l'application, `public/index.php`.

```apache
RewriteEngine On

# on redirige tout vers index.php
RewriteRule ^(.*)$ public/index.php?url=$1 [L,QSA]
```

- `RewriteEngine On` : Active le moteur de réécriture d'URL d'Apache.
- `RewriteRule ^(.*)$ public/index.php?url=$1 [L,QSA]` :
  - `^(.*)$` : Capture tout ce qui se trouve dans l'URL après le nom de domaine.
  - `public/index.php?url=$1` : Réécrit la requête vers `public/index.php`, en passant l'URL capturée comme paramètre `url` dans la query string.
  - `[L]` : Indique que c'est la dernière règle à appliquer.
  - `[QSA]` (Query String Append) : S'assure que les autres paramètres de la query string originale sont conservés.

## Installation et Utilisation

1.  Clonez le dépôt du projet (remplacez l'URL par celle de votre dépôt Git) :

    ```bash
    git clone https://github.com/KevinUrbain/Custom-built-dynamic-routing-system-in-an-MVC-PHP-framework.git
    ```

2.  Placez les fichiers sur votre serveur web (WAMP, MAMP, XAMPP, etc.). Assurez-vous que le `DocumentRoot` de votre Virtual Host pointe vers le dossier `public/`. Si vous placez le projet dans un sous-dossier (ex: `http://localhost/Router/`), le `.htaccess` fonctionnera tel quel.

3.  Naviguez vers les URL suivantes pour tester :
    - `http://localhost/Router/` -> Appelle `HomeController->index()`
    - `http://localhost/Router/user` -> Appelle `UserController->index()`
    - `http://localhost/Router/user/add` -> Appelle `UserController->add()`
    - `http://localhost/Router/user/findById/123` -> Appelle `UserController->findById('123')`
    - `http://localhost/Router/user/test/val1/val2/val3` -> Appelle `UserController->test('val1', 'val2', 'val3')`

### Créer une nouvelle route

Pour ajouter une nouvelle page, par exemple `/product/show/42` :

1.  Créez un nouveau fichier contrôleur `src/Controllers/ProductController.php`.
2.  Dans ce fichier, créez la classe `ProductController` avec une méthode publique `show($id)`.

```php
<?php

class ProductController
{
    public function show($id)
    {
        echo "Affichage du produit avec l'ID : {$id}";
    }
}
```

C'est tout ! Le routeur s'occupera du reste.

⚠️ Pas d'autoload implémenté, c'est pour cette raison que vous ne voyez pas les namespaces ni d'inclusion d'un fichier autoload.php (veuillez vous utiliser Composer pour cela)
