 <?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateComprasTable extends Migration {

	public function up()
	{
		Schema::create('compras', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('proveedor_id')->unsigned();
            $table->integer('tienda_id')->unsigned()->default(1);
            $table->integer('user_id')->unsigned();
            $table->string('numero_documento', 100);
            $table->date('fecha_documento');
            $table->decimal('saldo', 11, 5)->default(0.00);
            $table->decimal('total', 11, 5)->default(0.00);
            $table->boolean('completed')->default(0);
            $table->boolean('canceled')->default(0);
            $table->boolean('kardex')->default(0);
            $table->text('nota');
			$table->timestamps();
			$table->foreign('proveedor_id')->references('id')->on('proveedores')->onDelete('restrict')->onUpdate('cascade');
			$table->foreign('tienda_id')->references('id')->on('tiendas')->onDelete('restrict')->onUpdate('cascade');
			$table->foreign('user_id')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');
		});

		Schema::create('detalle_compras', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('compra_id')->unsigned();
			$table->integer('producto_id')->unsigned();
			$table->integer('cantidad');
			$table->decimal('precio', 11, 5);
			$table->text('serials');
			$table->timestamps();
			$table->foreign('compra_id')->references('id')->on('compras')->onDelete('cascade')->onUpdate('cascade');
			$table->foreign('producto_id')->references('id')->on('productos')->onDelete('restrict')->onUpdate('cascade');
		});

		Schema::create('pagos_compras', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('compra_id')->unsigned();
			$table->decimal('monto', 11, 5)->default(0.00);
			$table->integer('metodo_pago_id')->unsigned()->default(1);
			$table->timestamps();

			$table->foreign('compra_id')->references('id')->on('compras')->onDelete('cascade')->onUpdate('cascade');
			$table->foreign('metodo_pago_id')->references('id')->on('metodo_pago')->onDelete('restrict')->onUpdate('cascade');
		});
	}

	public function down()
	{
		Schema::drop('pagos_compras');
		Schema::drop('detalle_compras');
		Schema::drop('compras');
	}
}
