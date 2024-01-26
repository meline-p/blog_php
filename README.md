# Blog PHP

Welcome to my PHP blog!

---

## Installation

Download the ZIP from Github.

### Composer

Install all components by running the following command:

```jsx
composer install
```

### XAMPP

Install XAMPP: https://www.apachefriends.org/download.html
Start Apache and MySQL using the XAMPP control panel.

### Database

Access PhpMyAdmin admin via the XAMPP control panel.
Import the provided SQL file from the /database/blog_php.sql directory into PhpMyAdmin.

---

## Usage

### Terminal 1 : Launch the website

```jsx
php -S localhost:8080 -t public
```

Access the site at http://localhost:8080/.

### Terminal 2 : Launch MailDev

```jsx
maildev
```

Access the MailDev interface at http://localhost:1080/.

---

## Documentation

To generate documentation, use phpDocumentor:

```jsx
php phpDocumentor.phar run -d ./src -t docs/
```

Access the generated documentation in the docs/index.html directory. 
Launch Go Live on Visual Studio Code and access the online documentation at this address: http://localhost:8080/docs/index.html