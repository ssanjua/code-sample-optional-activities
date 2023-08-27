<?php
namespace App\Controllers;

use Bdt\Example\Controller;
use Bdt\Example\View;
use App\Models\Post;

/**
 * Handles CRUD operations related to posts.
 */

class PostsController extends Controller
{
    /**
     * Displays all posts.
     */
    public function index()
    {
        $posts = Post::findAll();
        $view = new View('index.html');
        $view->posts = $posts;
        return $view->render();
    }

    /**
     * Adds a new post.
     */
    public function add()
    {
        if (empty($this->application->post)) {
            header('Location: /');
            return;
        }

        // Input validation.
        // Trim() deletes blank spaces at the beginning and end of the string.
        $title = trim($this->application->post['title']);
        $body = trim($this->application->post['body']);
        $author = trim($this->application->post['author']);

        // Ensure inputs are not empty and are of reasonable length.
        if (empty($title) || strlen($title) > 255 || 
        empty($body) || strlen($body) > 500 || 
        empty($author) || strlen($author) > 100) {
    
        // If there is a mistake.
        header('Location: /?error=Invalid input');
        return;
        }

        // Check for duplicate titles.
        if (Post::titleExists($title)) {
            header('Location: /?error=Duplicated Title');
            return;
        }

        $post = new Post();
        $post->title  = $this->application->post['title'];
        $post->body   = $this->application->post['body'];
        $post->author = $this->application->post['author'];
        $post->save();

        // Redirect to homepage.
        header('Location: /');
        return;
    }

    /**
     * Edits an existing post.
     * 
     * @param int $id - The ID of the post to edit.
     */
    public function edit($id)
    {

        if (empty($this->application->post)) {
            header('Location: /');
            return;
        } 

        // Input validation.
        // Clean and assign local variables.
        $title = trim($this->application->post['title']);
        $body = trim($this->application->post['body']);
        $author = trim($this->application->post['author']);

        if (empty($title) || strlen($title) > 255 || 
            empty($body) || strlen($body) > 500 || 
            empty($author) || strlen($author) > 100) {
            
            // Error:
            header('Location: /?error=Invalid input');
            return;
        }

        // Check for duplicate titles, excluding the current post being edited.
        if (Post::titleExists($title, $id)) {
            header('Location: /?error=Duplicated Title');
            return;
        }

        // Search the post user wants to edit.
        $post = Post::findById($id);
        if (!$post) {
            header('Location: /');
            return;
        }

        // Update and save the post.
        $post->title  = $this->application->post['title'];
        $post->body   = $this->application->post['body'];
        $post->author = $this->application->post['author'];
        $post->save();

        // Redirect to homepage.
        header('Location: /');
        return;  
    }

    /**
     * Deletes a post.
     * 
     * @param int $id - The ID of the post to delete.
     */
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