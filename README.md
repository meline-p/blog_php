# Blog PHP

Bienvenue sur mon blog PHP !

---

## Installation

### Composer

Assurez-vous d'avoir Composer installé.

```jsx
composer install
```

### Base de Données

Importez le fichier SQL fourni dans le répertoire database/.

```jsx
mysql -u VOTRE_UTILISATEUR -p VOTRE_MOT_DE_PASSE < database/nom_du_fichier.sql
```

### Xampp

Assurez-vous que Xampp est installé sur votre machine.
Lancez Apache et MySQL via le panneau de contrôle Xampp.

---

## Utilisation

### Terminal 1 : Lancer le site web

```jsx
php -S localhost:8080 -t public
```

Accédez au site à l'adresse http://localhost:8080/.

### Terminal 2 : Lancer MailDev

```jsx
maildev
```

Accédez à l'interface MailDev à http://localhost:1080/.

---

## Documentation

Pour générer la documentation, utilisez phpDocumentor.

```jsx
php phpDocumentor.phar run -d ./src -t docs/
```

Accédez à la documentation générée dans le répertoire docs/.