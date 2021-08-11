<?php

declare(strict_types=1);

use Slim\App;
use App\HelloController;
use App\StockController;
use App\UserController;

return function (App $app) {
    // unprotected routes
    $app->get('/hello/{name}', HelloController::class . ':hello');
    $app->get('/bye/{name}', HelloController::class . ':bye');

    $app->get('/stock', StockController::class . ':query');
    $app->get('/history', StockController::class . ':history');

    $app->post('/users', UserController::class . ':store');
    $app->post('/login', UserController::class . ':login');
    $app->get('/logout', UserController::class . ':logout');
    
    // protected routes
};
