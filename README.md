# Blog PHP

Welcome to my PHP blog!

---

## Installation

Download the ZIP from Github or clone the project :

```jsx
git clone "https://github.com/meline-p/blog_php"
```

### Composer

Install all components by running the following command:

```jsx
composer install
```

### Database

Import the provided SQL file from the /database/blog_php.sql directory.

Change the environment variables DB_USERNAME, DB_PASSWORD and DB_UNIX_SOCKET according to your SQL configuration in the .env file.

### MailDev

MailDev installation : https://github.com/maildev/maildev

Install MailDev with npm :

```jsx
npm install -g maildev
```

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

To generate documentation, use phpDocumentor.
You can download the latest PHAR file from https://phpdoc.org/phpDocumentor.phar and put it at the root of the project.
Execute this command:

```jsx
php phpDocumentor.phar run -d ./src -t docs/
```

Access the generated documentation in the docs/index.html directory. 
Launch Go Live on Visual Studio Code and access the online documentation in the docs directory.