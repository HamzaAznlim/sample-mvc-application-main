<?php

namespace app\controllers ;

class NotfoundController
{
    public function index ($route){

        return $route->view('notFound/not_found');

    }
}