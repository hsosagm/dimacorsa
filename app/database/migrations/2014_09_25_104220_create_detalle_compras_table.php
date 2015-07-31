 <?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDetalleComprasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('detalle_compras', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('compra_id')->unsigned();
			$table->integer('producto_id')->unsigned();
			$table->integer('cantidad');
			$table->decimal('precio', 8, 2);
			$table->text('serials');
			
			$table->timestamps();

			$table->foreign('compra_id')->references('id')->on('compras')->onDelete('cascade')->onUpdate('cascade');
			$table->foreign('producto_id')->references('id')->on('productos')->onDelete('restrict')->onUpdate('cascade');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('detalle_compras');
	}

}
