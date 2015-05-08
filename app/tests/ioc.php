<?php


// test one whith App::bind() and App::make();
class Car {

    protected $gasolina;
    protected $diesel;

    public function __construct(Gasolina $gasolina, Diesel $diesel)
    {
        $this->gasolina = $gasolina;
        $this->diesel = $diesel;    
    }

    public function llenarGasolina($litros)
    {
        return $litros * $this->gasolina->precio();
    }

    public function llenarDiesel($litros)
    {
        return $litros * $this->diesel->precio();
    }
}

 
class Gasolina {

    public function precio()
    {
        return 130.7;
    }
}
 
class Diesel {

    public function precio()
    {
        return 120.7;
    }
}
 
App::bind('Car', function() {
    return new Gasolina;
    return new Diesel;
});
 
Route::get('/ioc', function()
{

    $mazda = App::make('car');
     
    return $mazda->llenarDiesel(1);
});


// test two with dependency inyection testeable
class Car {

    protected $gasolina;
    protected $diesel;

    public function __construct(Gasolina $gasolina, Diesel $diesel)
    {
        $this->gasolina = $gasolina;
        $this->diesel = $diesel;    
    }

    public function llenarGasolina($litros)
    {
        return $litros * $this->gasolina->precio();
    }

    public function llenarDiesel($litros)
    {
        return $litros * $this->diesel->precio();
    }
}

 
class Gasolina {

    public function precio()
    {
        return 130.7;
    }
}
 
class Diesel {

    public function precio()
    {
        return 120.7;
    }
}
 
 
Route::get('/ioc', function()
{

    $mazda = new Car(new Gasolina, new Diesel);
     
    $precio = $mazda->llenarGasolina(1);

    return $precio;
});


// test tree with dependency inyection
class Car {

    protected $gasolina;
    protected $diesel;

    public function __construct()
    {
        $this->gasolina = new Gasolina;
        $this->diesel = new Diesel;    
    }

    public function llenarGasolina($litros)
    {
        return $litros * $this->gasolina->precio();
    }

    public function llenarDiesel($litros)
    {
        return $litros * $this->diesel->precio();
    }
}

 
class Gasolina {

    public function precio()
    {
        return 130.7;
    }
}
 
class Diesel {

    public function precio()
    {
        return 120.7;
    }
}
 
 
Route::get('/ioc', function()
{

    $mazda = new Car();
     
    $precio = $mazda->llenarGasolina(1);

    return $precio;
});
