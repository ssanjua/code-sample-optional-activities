# BDT Example App 

by Pau Pallares *aka ssanjua*

## Implemented Features:

1. **Author Input:** An "Author" field has been added to the user interface to allow the insertion of new Posts.
2. **Edit Posts:** It's now possible to edit an existing post.
3. **Delete Posts**: The feature to delete an existing post has been implemented.
4. **Input Validation:** Input validation has been implemented to ensure entered text strings have a reasonable length.
5. **Prevent Duplicate Post Titles:** The application now checks if a post title already exists before allowing its creation.
6. **Dockerization:** The application has been dockerized for easier deployment and testing.

## Changes Made:

- In the frontend, an author field and links for "Edit" and "Delete" were added in `/app/views/index.html`
- Functions for editing and deleting posts were added in `/app/Controllers/PostsController.php`
- Routes were added to activate the edit and delete controllers in `/public/index.php`
- Modified the run() function to accept more complex route parameters in `/src/Application.php`
- A function was implemented to prevent duplicate post titles in 
`app/Models/Post.php`

## Installation

1. Make sure the root directory has write access:
<code> 
	
	chmod a+w . 
</code>

2. Install required vendors with composer:
<code>

    php composer.phar install
</code>

3. You can run the application with the built-in server:
<code>

    php -S localhost:8000 public/index.php
</code>

4. Or mount with Apache or your webserver of choice.

## Docker (Optional)

1. Build the image:

<code> 
	
	docker build -t bdt-example-app . 
</code>

2. Run the container:
<code> 
	
	docker run -d -p 8080:80 --name [name] bdt-example-app
</code>


## Directory Structure

* `/app` - application business-logic
* `/src` - lightweight MVC framework, for example only
* `/public/index.php` - front-controller for intercepting requests

### Languages and Tools:

<p align="center">
                <a href="https://skillicons.dev">
                  <img src="https://skillicons.dev/icons?i=php,html,js,sqlite,git,vscode,github,docker" />
                </a>
              </p>



