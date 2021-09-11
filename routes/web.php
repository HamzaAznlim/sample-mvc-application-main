<?php
use app\controllers\MainController;

/**
 *------------------------------------------------------
 * crud operations (Create , Read , Update , Delete)
 *------------------------------------------------------
 */


/**
 * Create
 *
 */
$this->get('/', [MainController::class,'index']);
$this->post('/user/save', [MainController::class,'store']);

/**
 * Read
 *
 */
$this->get('/user/{id}', [MainController::class,'showOne']);

/**
 * Update
 */

$this->get('/edit/{id}', [MainController::class,'edit']);
/**
 * Delete
 */
$this->get('/delete/{id}', [MainController::class,'delete']);
