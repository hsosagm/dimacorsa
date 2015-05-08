<?php

class TiendasTableSeeder extends Seeder {

	public function run()
	{
		$tiendas = [
		            [
		                'nombre' => 'Click',
		                'direccion' => 'Chiquimula',
		                'telefono' => '7942-1383',
		                'status' => '1'
		            ],
		        ];

        foreach($tiendas as $tienda){
            Tienda::create($tienda);
        }
	}

}
