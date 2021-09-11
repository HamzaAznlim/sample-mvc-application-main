# sample-mvc-application

The Model-View-Controller (MVC) pattern

## how to run app

1. First, download the sample-mvc-application, either directly or by cloning the repo.
2. install all dependencies using the `composer update`
3. if you have PHP server installed go inside the public folder then run `php -S localhost:5050`,
   if you have xampp go inside htdocs then place your folder.
4. Open [config/config.php](config/config.php) and enter your database configuration data.

## Configuration

Configuration settings are stored in the [config/config.php](config/config.php) Default settings include database connection data You can add your own configuration settings in here.

## Routing

The [Router](Router.php) translates URLs into controllers and actions. Routes are added in the [routes/web.php](routes/web.php). A sample Crud route is included

Routes are added with the `get` or `post` method. You can add fixed URL routes, and specify the controller and action, like this:

```php
$this->get('/', [MainController::class,'index']);
$this->post('/user/save', [MainController::class,'store']);
```

you can also specify route parameters like this:

```php
$this->get('/edit/{id}', [MainController::class,'edit']);
$this->get('/delete/{id}', [MainController::class,'delete']);
```

## Controllers

Controllers respond to user actions (clicking on a link, submitting a form etc..)
every Controller action have access to the Router and Request class methods
as a callback , like this:

```php
public function store(Router $route, Request $request)
    {
        $users =  UserModel::Get();
        
        if (!$users) {
            $request->redirect('/');
        }else{
            return $route->view("index", compact('users'));
        }
    }
```

## View

A view is some form of visualization of the state of the model.
The view renders the contents of a model via the controller View files go in the `/Views`
[views](views)

the view method will render the contents it takes two parameters: path to the view file  and data pass in like this:

```php
public function index(Router $route)
    {
        $users =  UserModel::Get();
        
        return $route->view("index", compact('users')); 
        /* 
        *    OR
        */ 
        return $route->view("index",['users' => $users]);
        
    }
```

## Models

1. A model is an object representing data or even activity,  database table
2. The model represents enterprise data and the business rules that govern access to and updates of this data.
3. The model is the piece that represents the state and low-level behavior of the component. It manages the state and conducts all transformations on that state. The model has no specific knowledge of either its controllers or its views. The view is the piece that manages the visual display of the state represented by the model. A model can have more than one view

example of  UserModel  :

```php
class UserModel extends ModelAbstract
{
    protected static string $table ='user_';
    public $name;
    public $Email;
    public $password;
    public $Age ;

    protected static $primaryKey = 'id';
    protected static $schema = [

        'name'          => self::STR_VAL,
        'Email'         => self::STR_VAL,
        'password'      => self::STR_VAL,
        'Age'           => self::INT_VAL,
    ];
}
```

crud operations (Create , Read , Update , Delete) :

#### Create

```php
    $users = new UserModel();
    $users->create(['hamza','hamza@gmail.com','dqsd§54dq231',22]);
```

NOTICE !! When you pass array to create method `$users->create(array())` pass theme with the same order as you defined in your model schema

#### Read

```php
    $users =  UserModel::Get();
```

#### Update

```php
    $users = new UserModel();

    $user = $users->find(2);
    $user->name = "New Hamza Anzlim";
    $user->save();
```

#### Delete

```php
    $users = new UserModel();

    $user->find(2)->delete();

```
