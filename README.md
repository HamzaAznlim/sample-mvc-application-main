# sample-mvc-application

The Model-View-Controller (MVC) pattern

## how to run app

1. First, download the sample-mvc-application, either directly or by cloning the repo.
2. install all dependencies using the `composer update`
3. if you have PHP server installed go inside the public folder then run `php -S localhost:5050`,
if you have xampp go inside htdocs then place your folder.
4. Open [config/config.php](Config.php) and enter your database configuration data.

## Configuration

Configuration settings are stored in the [config/config.php](Config.php)  Default settings include database connection data You can add your own configuration settings in here.

## Routing

The [Router](Router.php) translates URLs into controllers and actions. Routes are added in the [routes/web.php](web.php). A sample Crud route is included that routes to the `index` , `user` action in the [controllers/MainController.php](controllers/MainController.php).

Routes are added with the `git` or `post` method. You can add fixed URL routes, and specify the controller and action, like this:

```php
$this->get('/', [MainController::class,'index']);
$this->post('/user/save', [MainController::class,'store']);
```

you can also specify route parameters like this:

```php
$this->get('/edit/{id}', [MainController::class,'edit']);
$this->get('/delete/{id}', [MainController::class,'delete']);
```
