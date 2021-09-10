<?php

namespace app\controllers ;

use app\models\tables\UserModel;
use app\Router;
use app\Request;

class MainController
{

    /**
     *
     * show users
     */

    public function index(Router $route)
    {
        $users =  UserModel::Get();
        return   $route->view("index", compact('users'));
    }


    /**
    * Store one user
    *
    */

    public function store(Router $route, Request $request)
    {
        $users = new UserModel();
        
        if ($users->create($request->req_post())) {
            $request->redirect('/');
        }
    }

    /**
    * show  one user
    *
    */

    public function showOne(Router $route, Request $request)
    {
        $id = intval($route->params['id']);
        $users = new UserModel();

        $user = $users->find($id);
        
        return   $route->view("user", compact('user'));
    }

    /**
    * Edit User
    *
    */

    public function edit(Router $route, Request $request)
    {
        $id = intval($route->params['id']);
        $user = new UserModel();
        $user = $user->find($id);

        $user->name = "Hamza Anzlim";
       
        if ($user->save()) {
            $request->redirect('/');
        }
    }

    /**
    * Delete User
    *
    */

    public function delete(Router $route, Request $request)
    {
        $id = intval($route->params['id']);
        $user = new UserModel();
        
        if ($user->find($id)->delete()) {
            $request->redirect('/');
        }
    }

    /**
    * NOT FOUND VIEW
    *
    */

    public function notFound(Router $route)
    {
        return   $route->view("viewNotFound");
    }
}
