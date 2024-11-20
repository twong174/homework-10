<?php
require_once "../app/models/Model.php";
require_once "../app/models/User.php";
require_once "../app/models/Post.php";
require_once "../app/controllers/UserController.php";
require_once "../app/controllers/PostController.php";

$env = parse_ini_file('../.env');
define('DBNAME', $env['DBNAME']);
define('DBHOST', $env['DBHOST']);
define('DBUSER', $env['DBUSER']);
define('DBPASS', $env['DBPASS']);

use app\controllers\UserController;
use app\controllers\PostController;

$uri = strtok($_SERVER["REQUEST_URI"], '?');

$uriArray = explode("/", $uri);

if ($uriArray[1] === 'api' && $uriArray[2] === 'users') {
    $userController = new UserController();
    $id = isset($uriArray[3]) ? intval($uriArray[3]) : null;

    switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            if ($id) {
                $userController->getUserByID($id);
            } else {
                $userController->getAllUsers();
            }
            break;
        case 'POST':
            $userController->saveUser();
            break;
        case 'PUT':
            $userController->updateUser($id);
            break;
        case 'DELETE':
            $userController->deleteUser($id);
            break;
    }
}

if ($uriArray[1] === 'api' && $uriArray[2] === 'posts') {
    $postController = new PostController();
    $id = isset($uriArray[3]) ? intval($uriArray[3]) : null;

    switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            if ($id) {
                $postController->getPostByID($id);
            } else {
                $postController->getAllPosts();
            }
            break;
        case 'POST':
            $postController->savePost();
            break;
        case 'PUT':
            $postController->updatePost($id);
            break;
        case 'DELETE':
            $postController->deletePost($id);
            break;
    }
}

if ($uri === '/users-add' && $_SERVER['REQUEST_METHOD'] === 'GET') {
    $userController = new UserController();
    $userController->usersAddView();
} elseif ($uriArray[1] === 'users-update' && $_SERVER['REQUEST_METHOD'] === 'GET') {
    $userController = new UserController();
    $userController->usersUpdateView();
} elseif ($uriArray[1] === 'users-delete' && $_SERVER['REQUEST_METHOD'] === 'GET') {
    $userController = new UserController();
    $userController->usersDeleteView();
} elseif ($uriArray[1] === '' && $_SERVER['REQUEST_METHOD'] === 'GET') {
    $userController = new UserController();
    $userController->usersView();
}

if ($uri === '/posts-add' && $_SERVER['REQUEST_METHOD'] === 'GET') {
    $postController = new PostController();
    $postController->postsAddView();
} elseif ($uriArray[1] === 'posts-update' && $_SERVER['REQUEST_METHOD'] === 'GET') {
    $postController = new PostController();
    $postController->postsUpdateView();
} elseif ($uriArray[1] === 'posts-delete' && $_SERVER['REQUEST_METHOD'] === 'GET') {
    $postController = new PostController();
    $postController->postsDeleteView();
}

include '../public/assets/views/notFound.html';
exit();
