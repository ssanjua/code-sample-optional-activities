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
        $post = new Post();
        $post->title = $this->application->post['title'];
        $post->body  = $this->application->post['body'];
        $post->save();
        header('Location: /');
        return;
    }
}