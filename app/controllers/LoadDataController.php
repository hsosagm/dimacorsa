<?php

class LoadDataController extends \Controller {
	
	public function index()
	{
        DB::table('compras')->delete();
        // $this->usuarios();
         // $this->categorias();
         // $this->marcas();

         //     $precio_venta = new PrecioVenta;
         //     $precio_venta->id = 1;
         //     $precio_venta->nombre = 'Base';
         //     $precio_venta->save();

        //$this->productos(1);
       // $this->productos(2);

        // $this->clientes(1);
        // $this->clientes(2);
        // $this->clientes(3);

        // $this->soporte();
        // $this->gastos();
        // $this->egresos();
        // $this->proveedores();

    }


    public function readCSV($csvFile)
    {
        $file_handle = fopen($csvFile, 'r');

        while (!feof($file_handle))
        {
            $line_of_text[] = fgetcsv($file_handle, 1024);
        }

        fclose($file_handle);

        return $line_of_text;
    }

    public function usuarios()
    {
        $csvFile = app_path().'/tablas/usuarios.csv';

        $items = $this->readCSV($csvFile);

        $counter = 0;

        foreach ($items as $item) {

            $counter++;

            $user = new User;
            $user->id     = $item[0];
            $user->tienda_id = $item[6];
            $user->username  = "usuario".$counter;
            $user->nombre = $item[1];
            $user->apellido = $item[2];
            $user->email = "email".$counter."@gmail.com";
            $user->password = "123456";
            $user->status = $item[7];
            $user->save();
        }

        echo $counter. " " ."usuarios ingresados!";
        echo "<br>";

    }

    public function categorias()
    {
        $csvFile = app_path().'/tablas/categorias.csv';

        $items = $this->readCSV($csvFile);

        $counter = 0;

        DB::table('categorias')->delete();

        foreach ($items as $item) {

            $counter++;

            $categoria = new Categoria;
            $categoria->id     = $item[0];
            $categoria->nombre = $item[1];
            $categoria->save();

        }
        echo $counter. " " ."categoria ingresadas!";
        echo "<br>";

    }

    public function marcas()
    {
        $csvFile = app_path().'/tablas/marca.csv';

        $items = $this->readCSV($csvFile);

        $counter = 0;

        DB::table('marcas')->delete();

        foreach ($items as $item) {

            $counter++;

            $marca = new Marca;
            $marca->id     = $item[0];
            $marca->nombre = $item[1];
            $marca->save();

        }
        echo $counter. " " ."marcas ingresadas!";
        echo "<br>";
    }

    public function productos($num)
    {
        if ($num == 1) 
        {
            $csvFile = app_path().'/tablas/producto.csv';
            DB::table('productos')->delete();
        }
        if($num == 2)
        {
            $csvFile = app_path().'/tablas/producto1.csv';
        }
        
        $items = $this->readCSV($csvFile);

        $counter = 0;

        foreach ($items as $item) {

            $counter++;

            $producto = new Producto;
            $producto->id     = $item[0];
            $producto->categoria_id = $item[9];
            $producto->marca_id = $item[2];
            $producto->codigo = $item[1];
            $producto->descripcion = $item[3];
            $producto->p_costo = $item[4];
            $producto->p_publico = $item[5];
            $producto->precio_venta_id = 1;
            $producto->save();
        }

        echo $counter. " " ."productos ingresados!";
        echo "<br>";
    }

    public function clientes($num)
    {
        if ($num == 1) 
        {
             $csvFile = app_path().'/tablas/cliente.csv';
             DB::table('clientes')->delete();
        }
        if ($num == 2) 
        {
             $csvFile = app_path().'/tablas/cliente1.csv';
        }
        if ($num == 3) 
        {
             $csvFile = app_path().'/tablas/cliente2.csv';
        }

        $items = $this->readCSV($csvFile);

        $counter = 0;

       

        foreach ($items as $item) {

            $counter++;

            $cliente = new Cliente;
            $cliente->id     = $item[0];
            $cliente->nombre = $item[1];
            $cliente->apellido = $item[2];
            $cliente->direccion = $item[3];
            $cliente->telefono = $item[4];
            $cliente->nit = $item[5];
            $cliente->email = $item[6];
            $cliente->save();
        }

        echo $counter. " " ."clientes ingresados!";
        echo "<br>";
    }

    public function soporte()
    {
        $csvFile = app_path().'/tablas/soporte.csv';

        $items = $this->readCSV($csvFile);

        $counter = 0;

        DB::table('soporte')->delete();

        foreach ($items as $item) {

            $counter++;

            $soporte = new Soporte;
            $soporte->id     = $item[0];
            $soporte->user_id = $item[2];
            $soporte->tienda_id = $item[1];
            $soporte->created_at = $item[3];
            $soporte->save();

        }

        echo $counter. " " ."soporte ingresados!";
        echo "<br>";

       $csvFile = app_path().'/tablas/detallesoporte.csv';

        $items = $this->readCSV($csvFile);

        $counter = 0;

        DB::table('detalle_soporte')->delete();

        foreach ($items as $item) {

            $counter++;

            $detalle_soporte = new DetalleSoporte;
            $detalle_soporte->id     = $item[0];
            $detalle_soporte->descripcion = $item[2];
            $detalle_soporte->monto = $item[3];
            $detalle_soporte->soporte_id = $item[1];
            $detalle_soporte->metodo_pago_id = 1;
            $detalle_soporte->save();
        }

        echo $counter. " " ."detalle_soporte ingresados!";
        echo "<br>";
    }

    public function gastos()
    {
         $csvFile = app_path().'/tablas/gastos.csv';

        $items = $this->readCSV($csvFile);

        $counter = 0;

        DB::table('gastos')->delete();

        foreach ($items as $item) {

            $counter++;

            $gastos = new Gasto;
            $gastos->id     = $item[0];
            $gastos->user_id = $item[2];
            $gastos->tienda_id = $item[1];
            $gastos->created_at = $item[3];
            $gastos->save();

        }

        echo $counter. " " ."Gastos ingresados!";
        echo "<br>";

       $csvFile = app_path().'/tablas/detallegastos.csv';

        $items = $this->readCSV($csvFile);

        $counter = 0;

        DB::table('detalle_gastos')->delete();

        foreach ($items as $item) {

            $counter++;

            $detalle_gasto = new DetalleGasto;
            $detalle_gasto->id     = $item[0];
            $detalle_gasto->descripcion = $item[2];
            $detalle_gasto->monto = $item[3];
            $detalle_gasto->gasto_id = $item[1];
            $detalle_gasto->metodo_pago_id = 1;
            $detalle_gasto->save();
        }

        echo $counter. " " ."detalle_gastos ingresados!";
        echo "<br>";
    }

    public function egresos()
    { 
         $csvFile = app_path().'/tablas/egresos.csv';

        $items = $this->readCSV($csvFile);

        $counter = 0;

        DB::table('egresos')->delete();

        foreach ($items as $item) {

            $counter++;

            $egreso = new Egreso;
            $egreso->id     = $item[0];
            $egreso->user_id = $item[2];
            $egreso->tienda_id = $item[1];
            $egreso->created_at = $item[3];
            $egreso->save();

        }

        echo $counter. " " ."egresos ingresados!";
        echo "<br>";

       $csvFile = app_path().'/tablas/egresosdetalle.csv';

        $items = $this->readCSV($csvFile);

        $counter = 0;

        DB::table('detalle_egresos')->delete();

        foreach ($items as $item) {

            $counter++;

            $detalle_egreso = new DetalleEgreso;
            $detalle_egreso->id     = $item[0];
            $detalle_egreso->descripcion = $item[2];
            $detalle_egreso->monto = $item[3];
            $detalle_egreso->egreso_id = $item[1];
            $detalle_egreso->metodo_pago_id = 1;
            $detalle_egreso->save();
        }

        echo $counter. " " ."detalle_egresos ingresados!";
        echo "<br>";
    }

    public function proveedores()
    {

       $csvFile = app_path().'/tablas/proveedor.csv';

        $items = $this->readCSV($csvFile);

        $counter = 0;

        DB::table('proveedores')->delete();

        foreach ($items as $item) {

            $counter++;

            $proveedor = new Proveedor;
            $proveedor->id     = $item[0];
            $proveedor->nombre = $item[1];
            $proveedor->direccion = $item[2];
            $proveedor->telefono = $item[3];
            $proveedor->save();

        }

        echo $counter. " " ."proveedores ingresados!";
        echo "<br>";
    }
}
