<?php
namespace App\Controllers;

use Bdt\Example\Controller;
use Bdt\Example\View;
use App\Models\Post;

class PostsController extends Controller
{
    public function index()
    {
        $posts = Post::findAll();
        $view = new View('index.html');
        $view->posts = $posts;
        return $view->render();
    }

    public function add()
    {
        if (empty($this->application->post)) {
            header('Location: /');
            return;
        }

        // input validation
        // trim() deletes blank spaces at the beginning and end of the string
        $title = trim($this->application->post['title']);
        $body = trim($this->application->post['body']);
        $author = trim($this->application->post['author']);

        // lets check the inputs:
        // - make sure: no empty field.
        // - make sure: lenght is reasonable.
        if (empty($title) || strlen($title) > 255 || 
        empty($body) || strlen($body) > 500 || 
        empty($author) || strlen($author) > 100) {
    
        // if there is a mistake:
        header('Location: /?error=Invalid input');
        return;
        }

        // Comprobar títulos duplicados
        if (Post::titleExists($title)) {
            header('Location: /?error=Duplicated Title');
            return;
        }


        $post = new Post();
        $post->title  = $this->application->post['title'];
        $post->body   = $this->application->post['body'];
        $post->author = $this->application->post['author'];
        $post->save();

        // homepage
        header('Location: /');
        return;
    }

    // add function to edit post
    public function edit($id)
    {

        if (empty($this->application->post)) {
            header('Location: /');
            return;
        } 

        // input validation
        // clean and assign local variables
        $title = trim($this->application->post['title']);
        $body = trim($this->application->post['body']);
        $author = trim($this->application->post['author']);

        // same lenght validation 
        if (empty($title) || strlen($title) > 255 || 
            empty($body) || strlen($body) > 500 || 
            empty($author) || strlen($author) > 100) {
            
            // if there is a mistake:
            header('Location: /?error=Invalid input');
            return;
        }

        if (Post::titleExists($title, $id)) {
            header('Location: /?error=Duplicated Title');
            return;
        }

        // search the post user wants to edit
        $post = Post::findById($id);
        if (!$post) {
            header('Location: /');
            return;
        }

        // update and save the post
        $post->title  = $this->application->post['title'];
        $post->body   = $this->application->post['body'];
        $post->author = $this->application->post['author'];
        $post->save();

        // homepage
        header('Location: /');
        return;  
    }

    public function delete($id)
    {
        $post = Post::findById($id);
        if (!$post) {
            header('Location: /');
            return;
        }

        $post->delete();
        header('Location: /');
        return;
    }

}