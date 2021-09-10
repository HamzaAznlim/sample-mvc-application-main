<?php
use app\controllers\MainController;

$this->get('/', [MainController::class,'index']);

$this->post('/user/save', [MainController::class,'store']);


$this->get('/user/{id}', [MainController::class,'showOne']);

$this->get('/edit/{id}', [MainController::class,'edit']);

$this->get('/delete/{id}', [MainController::class,'delete']);
