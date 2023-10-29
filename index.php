<?php
require './vendor/autoload.php';

define('UPLOAD_PATH', __DIR__ . DIRECTORY_SEPARATOR . 'img');
define('ALLOWED_MIMES', ['image/jpeg', 'image/png']);

// Can be uncommented for more error details
// define('DEBUG_TIME', microtime(true));
// $whoops = new \Whoops\Run;
// $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
// $whoops->register();


$router = new App\Router(__DIR__ . '/src/View');
$router
    //Authentication
    ->match('/', 'auth/login', 'login')
    ->match('/register', 'auth/register', 'register')
    ->post('/logout', 'auth/logout', 'logout')
    //Display of all properties
    ->get('/properties', 'property/index', 'properties')
    //Property creation
    ->match('/property/new', 'property/new', 'new_property')
    //Property modification
    ->match('/property/edit/[i:id]', 'property/edit', 'edit_property')
    //Display a property
    ->get('/property/[i:id]', 'property/show', 'show_property')
    //Delete property
    ->post('/property/delete/[i:id]', 'property/delete', 'delete_property')
    // Start the router
    ->run();
