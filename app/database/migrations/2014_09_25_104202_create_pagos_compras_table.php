 <?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePagosComprasTable extends Migration {

	public function up()
	{
		Schema::create('pagos_compras', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('compra_id')->unsigned();
			$table->decimal('monto', 8, 2)->default(0.00);
			$table->integer('metodo_pago_id')->unsigned()->default(1);
			$table->timestamps();

			$table->foreign('compra_id')->references('id')->on('compras')->onDelete('cascade')->onUpdate('cascade');
			$table->foreign('metodo_pago_id')->references('id')->on('metodo_pago')->onDelete('restrict')->onUpdate('cascade');
		});
	}

	public function down()
	{
		Schema::drop('pagos_compras');
	}
}
