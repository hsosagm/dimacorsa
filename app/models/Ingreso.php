 <?php
use \NEkman\ModelLogger\Contract\Logable;

class Ingreso extends \BaseModel implements Logable{

    protected $table = 'ingresos';
    
	protected $guarded = array('id');

	protected $rules = array(
		'tienda_id'  => 'required|integer',
		'user_id'    => 'required|integer',
	);

	public function tienda()
    {
        return $this->belongsTo('Tienda');    
    }

    public function user()
    {
        return $this->belongsTo('User');    
    }

    public function detalle_ingresos()
    {
        return $this->hasMany('DetalleEgreso');
    }

    public function getLogName()
    {
        return $this->id;
    }
}