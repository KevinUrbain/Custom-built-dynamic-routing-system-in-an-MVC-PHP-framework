--

# PHP Router From Scratch

This project is a simple and lightweight PHP router, designed to illustrate the basics of the "Front Controller" pattern and object-oriented PHP routing.

## How It Works

The router intercepts all requests thanks to a rewrite rule in the `.htaccess` file. The request is redirected to `public/index.php`, which instantiates and runs the router.

The router then parses the URL to determine which controller and method to call. The URL structure is as follows:

`/controller/method/param1/param2/...`

- **controller**: The name of the controller to call. If not specified, `HomeController` is used by default.
- **method**: The name of the method to execute in the controller. If not specified, the `index()` method is used by default.
- **param1, param2, ...**: The parameters to pass to the method.

For example, the URL `/user/findById/123` will be processed as follows:

1.  **Controller**: `user` -> `UserController`
2.  **Method**: `findById`
3.  **Parameter**: `123`

The router will therefore call the `findById('123')` method of the `UserController` class.

## Features

- Routing based on URL segments.
- Automatic loading of controllers (`/user` loads `UserController.php`).
- Dynamic calling of controller methods.
- Passing URL segments as parameters to methods.
- Basic handling of 404 errors (controller, method, or file not found, insufficient number of parameters).

## Architecture and `.htaccess`

For the router to work, the project must follow the following folder structure:

```text
/
├── .htaccess
├── public/
│   └── index.php       # Single entry point (Front Controller)
└── src/
    ├── Controllers/    # Contains controller classes
    │   ├── HomeController.php
    │   └── UserController.php
    └── Core/
        └── Router.php      # Main router class
```

### The `.htaccess` file

The `.htaccess` file at the root of the project is crucial. It redirects all requests to the application's entry point, `public/index.php`.

```apache
RewriteEngine On

# redirect everything to index.php
RewriteRule ^(.*)$ public/index.php?url=$1 [L,QSA]
```

- `RewriteEngine On`: Activates Apache's URL rewriting engine.
- `RewriteRule ^(.*)$ public/index.php?url=$1 [L,QSA]`:
  - `^(.*)$`: Captures everything in the URL after the domain name.
  - `public/index.php?url=$1`: Rewrites the request to `public/index.php`, passing the captured URL as a `url` parameter in the query string.
  - `[L]`: Indicates that this is the last rule to apply.
  - `[QSA]` (Query String Append): Ensures that other parameters from the original query string are preserved.

## Installation and Usage

1.  Clone the project repository (replace the URL with your Git repository's URL):

    ```bash
    git clone https://github.com/KevinUrbain/Custom-built-dynamic-routing-system-in-an-MVC-PHP-framework.git
    ```

2.  Place the files on your web server (WAMP, MAMP, XAMPP, etc.). Make sure your Virtual Host's `DocumentRoot` points to the `public/` directory. If you place the project in a subdirectory (e.g., `http://localhost/Router/`), the `.htaccess` will work as is.

3.  Navigate to the following URLs to test:
    - `http://localhost/Router/` -> Calls `HomeController->index()`
    - `http://localhost/Router/user` -> Calls `UserController->index()`
    - `http://localhost/Router/user/add` -> Calls `UserController->add()`
    - `http://localhost/Router/user/findById/123` -> Calls `UserController->findById('123')`
    - `http://localhost/Router/user/test/val1/val2/val3` -> Calls `UserController->test('val1', 'val2', 'val3')`

### Creating a new route

To add a new page, for example `/product/show/42`:

1.  Create a new controller file `src/Controllers/ProductController.php`.
2.  In this file, create the `ProductController` class with a public `show($id)` method.

```php
<?php

class ProductController
{
    public function show($id)
    {
        echo "Displaying product with ID: {$id}";
    }
}
```

That's it! The router will take care of the rest.

⚠️ No autoloader is implemented, which is why you don't see namespaces or an include for an `autoload.php` file (please use Composer for this).

---

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
