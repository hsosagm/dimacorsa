<?php

// example 1 //

interface CarInterface {
    public function start();
    public function gas();
    public function brake();
}
 
class Subaru implements CarInterface {
    public function start() {
        echo 'Starts great'.'<br>';
    }
    public function gas()  {
        echo 'Hit the gas and let the all wheel drive grip those back roads!'.'<br>';
    }
    public function brake() {
        echo 'Wow these Brembo brakes are powerful'.'<br>';
    }
}
 
App::bind('CarInterface', 'Subaru');

Route::get('interface', function()
{
    $car = App::make('CarInterface');  
    $car->start();
    $car->gas();
    $car->brake();
});


// example 2 // NOTA: en el constructor del controlador instanciamos la interface Logs, cuando hacemos el llamado al
// controlador en rutas debemos instancear a cualquier clase que implemente Logs

interface Logs {

    public function execute($msg);
}


class UserLogs implements Logs{

    public function execute($msg) 
    {
        return "User Logs " . $msg;
    }
}


class ProductsLogs implements Logs{

    public function execute($msg) 
    {
        return "Products Logs " . $msg;
    }
}


class InterfaceController
{
    protected $logger;
    
    public function __construct(Logs $logger)
    {
        $this->logger = $logger;
    }

    public function show()
    {
        $user = 'H sosa';
        return $this->logger->execute($user);
    }
}


Route::get('interface', function() {

    $interface = new InterfaceController(new ProductsLogs);
    echo $interface->show();
});