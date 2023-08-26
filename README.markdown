# BDT Example App

Given the existing structure, please implement the following:

1. Add an Author field to the user interface to allow inserting new Posts - it has already been added to the DB schema.
2. Edit an existing post.
3. Delete an existing post.

The code provided serves as a guidance only, feel free to modify it to
suit your needs.

Keep in mind that we are testing your PHP MVC and OOP knowledge; front-end
development is not being critiqued, though modify it if you wish.

**Optional:**
1. Implement input validation where necessary
2. Dockerize the application
3. Prevent duplicate post titles

## Installation

1. Make sure the root directory has write access: 
    chmod a+w .

2. Install required vendors with composer:
    php composer.phar install

3. You can run the application with the built-in server:
    php -S localhost:8000 public/index.php

4. Or mount with Apache or your webserver of choice.

## Directory Structure

* `/app` - application business-logic
* `/src` - lightweight MVC framework, for example only
* `/public/index.php` - front-controller for intercepting requests
